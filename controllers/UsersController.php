<?php

namespace Grocy\Controllers;

use Grocy\Controllers\Users\User;

class UsersController extends BaseController
{
	public function PermissionList(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, array $args)
	{
		User::checkPermission($request, User::PERMISSION_USERS_READ);
		return $this->renderPage($response, 'userpermissions', [
			'user' => $this->getDatabase()->users($args['userId']),
			'permissions' => $this->getDatabase()->uihelper_user_permissions()
				->where('parent IS NULL')->where('user_id', $args['userId'])
		]);
	}

	public function UserEditForm(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, array $args)
	{
		if ($args['userId'] == 'new')
		{
			User::checkPermission($request, User::PERMISSION_USERS_CREATE);
			return $this->renderPage($response, 'userform', [
				'mode' => 'create'
			]);
		}
		else
		{
			if ($args['userId'] == GROCY_USER_ID)
			{
				User::checkPermission($request, User::PERMISSION_USERS_EDIT_SELF);
			}
			else
			{
				User::checkPermission($request, User::PERMISSION_USERS_EDIT);
			}

			return $this->renderPage($response, 'userform', [
				'user' => $this->getDatabase()->users($args['userId']),
				'mode' => 'edit'
			]);
		}
	}

	public function UserSettings(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, array $args)
	{
		return $this->renderPage($response, 'usersettings', [
			'languages' => array_filter(scandir(__DIR__ . '/../localization'), function ($item) {
				if ($item == '.' || $item == '..')
				{
					return false;
				}

				return is_dir(__DIR__ . '/../localization/' . $item);
			})
		]);
	}

	public function UsersList(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, array $args)
	{
		User::checkPermission($request, User::PERMISSION_USERS_READ);
		return $this->renderPage($response, 'users', [
			'users' => $this->getDatabase()->users()->orderBy('username')
		]);
	}
}
