<?php

namespace Alfanjauhari\Crovid\Facades;

use Illuminate\Support\Facades\Facade;

class Crovid extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'crovid';
	}
}