<?php

namespace Core;

class Validate
{
    private array $data;
    private array $rules;
    private array $errors = [];

    public static function make(array $data, array $rules): self
    {
        $instance = new self();
        $instance->data = $data;
        $instance->rules = $rules;
        $instance->run();
        return $instance;
    }

    public function passed(): bool
    {
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    private function run(): void
    {
        foreach ($this->rules as $field => $ruleset) {
            $rules = explode('|', $ruleset);
            $value = $this->data[$field] ?? null;

            foreach ($rules as $rule) {
                $this->applyRule($field, $value, $rule);
            }
        }
    }

    private function applyRule(string $field, $value, string $rule): void
    {
        if (str_contains($rule, ':')) {
            [$rule, $param] = explode(':', $rule, 2);
        }

        switch ($rule) {
            case 'required':
                if ($value === null || $value === '') {
                    $this->addError($field, "Le champ $field est obligatoire");
                }
                break;

            case 'email':
                if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "Le champ $field doit être un email valide");
                }
                break;

            case 'numeric':
                if ($value !== null && !is_numeric($value)) {
                    $this->addError($field, "Le champ $field doit être numérique");
                }
                break;

            case 'min':
                if ($value !== null && strlen($value) < (int)$param) {
                    $this->addError($field, "Le champ $field doit contenir au moins $param caractères");
                }
                break;

            case 'max':
                if ($value !== null && strlen($value) > (int)$param) {
                    $this->addError($field, "Le champ $field doit contenir au maximum $param caractères");
                }
                break;

            case 'in':
                $allowed = explode(',', $param);
                if ($value !== null && !in_array($value, $allowed)) {
                    $this->addError($field, "La valeur de $field est invalide");
                }
                break;

            case 'confirmed':
                $confirmField = $field . '_confirmation';
                if (($this->data[$confirmField] ?? null) !== $value) {
                    $this->addError($field, "Le champ $field ne correspond pas à la confirmation");
                }
                break;
        }
    }

    private function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }
}
