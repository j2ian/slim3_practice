# respect/validation
    composer require respect/validation

## 參數

- `noWhitespace()` 不含空白格或\n
- `notEmpty()` 必填

## 自訂訊息
````php
    $errors = $e->findMessages([
        'notEmpty'     => '{{name}} 必填欄位',
        'noWhitespace' => '{{name}} 不能包含空白格',
    ]);
````

# twig 筆記

輸出變數中含有html的方法：
https://twig.symfony.com/doc/2.x/filters/raw.html

# flash
    composer require slim/flash

