<?php
namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    protected $errors;
    public function validate($request, array $rules)
    {
        //var_dump($rules);

        foreach ($rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            } catch (NestedValidationException $e) {
                $errors = $e->findMessages([
                    'notEmpty' => '此為必填欄位',
                    'noWhitespace' => '這個欄位不能包含空白格',
                ]);
                $this->errors[$field] = $e->getMessages();
            }
        }

        $_SESSION['errors'] = $this->errors;

        return $this;
    }
    public function failed()
    {
        return !empty($this->errors);

    }
}
