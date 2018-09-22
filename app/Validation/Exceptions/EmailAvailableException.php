<?php
namespace App\Validation\Exceptions;
use Respect\Validation\Exceptions\ValidationException;
class EmailAvailableException extends ValidationException
{
	public static $defaultTemplates = [
		self::MODE_DEFAULT => [
			self::STANDARD => '這個Email 已被註冊，請使用其他Email',
		],
	];
}