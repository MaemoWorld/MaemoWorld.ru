<?php

// Language definitions used in all admin files
$lang_admin_groups = array(

// admin_groups
'Group settings heading'		 => 'Настройки группы, которые действуют, если не перекрываются особыми настройками отдельных форумов',
'Group title label' 			 => 'Группа',
'User title label'  			 => 'Название',
'Group title head'  			 => 'Группа и название',
'Group title legend'			 => 'Установка названий',
'Group perms head'  			 => 'Права доступа группы',
'Group flood head'  			 => 'Установка интервалов времени между действиями',
'User title help'					=>	'Это название перекроет ранги пользователей, включённых в группу. Оставьте пустым, чтобы не менять ранги.',
'Remove group legend'   		 => 'Удаление группы',
'Permissions'   				 => 'Права',
'Moderation'					 => 'Модерирование',
'Allow moderate label'  		 => 'Разрешить модерирование пользователей.',
'Allow mod edit profiles label'  => 'Разрешить изменение профилей пользователей.',
'Allow mod edit username label'		=>	'Разрешить изменение имён пользователей.',
'Allow mod change pass label'    => 'Разрешить изменение паролей пользователей.',
'Allow mod bans label'  		 => 'Разрешить блокирование пользователей.',
'Allow read board label'		 => 'Разрешить просмотр форума.',
'Allow read board help' 		 => 'Эта настройка применяется ко всему форуму и не может (если выключена) быть перекрыта особыми настройками форума. Если она выключена, то пользователи из этой группы могут только входить/выходить с форума и регистрироваться.',
'Allow view users label'		 => 'Разрешить просмотр списка пользователей и их профилей.',
'Allow post replies label'  	 => 'Разрешить отвечать в темах.',
'Allow post topics label'   	 => 'Разрешить создание новых тем.',
'Allow edit posts label'		 => 'Разрешить редактирование своих сообщений.',
'Allow delete posts label'  	 => 'Разрешить удаление своих сообщений.',
'Allow delete topics label' 	 => 'Разрешить удаление своих тем (включая все ответы).',
'Allow set user title label'	 => 'Разрешить редактирование своих титулов.',
'Allow use search label'		 => 'Разрешить использование поиска.',
'Allow search users label'  	 => 'Разрешить использование поиска пользователей.',
'Allow send email label'		 => 'Разрешить отправлять сообщения по электронной почте другим пользователям.',
'Restrictions'  				 => 'Ограничения',
'Mod permissions'   			 => 'Права модераторов',
'User permissions'  			 => 'Права пользователей',
'Flood interval label'  		 => 'Интервал между сообщениями',
'Flood interval help'   		 => 'Количество секунд, которое должно пройти между двумя сообщениями пользователей из этой группы. Поставьте 0, чтобы выключить.',
'Search interval label' 		 => 'Интервал между поисками',
'Search interval help'  		 => 'Количество секунд, которое должно пройти между двумя попытками поиска по форуму пользователей из этой группы. Поставьте 0, чтобы выключить.',
'Email flood interval label'	 => 'Интервал между сообщениями по электронной почте',
'Email flood interval help' 	 => 'Количество секунд, которое должно пройти между двумя сообщениями по электронной почте пользователей из этой группы. Поставьте 0, чтобы выключить.',
'Allow moderate help'   		 => 'Для того чтобы пользователь в этой группе имел возможности модератора, он должен быть назначен модератором хотя бы в одном из форумов. Это можно сделать на странице администрирования пользователя, выбрав вкладку «Администрирование» в профиле пользователя.',
'Remove group'  				 => 'Удалить',
'Edit group'					 => 'Редактировать',
'default'   					 => '(по умолчанию)',
'Cannot remove group'   		 => 'Эту группу нельзя удалить.',
'Cannot remove default' 		 => 'Чтобы удалить эту группу, необходимо назначить другую группу «по умолчанию».',
'Remove group head' 			 => 'Удаление группы «%s» с %s пользователями',
'Remove group help' 			 => '(Переместить пользователей в эту группу)',
'Move users to' 				 => 'Переместить пользователей в группу',
'Cannot remove default group'    => 'Группа «по умолчанию» не может быть удалена. Для того чтобы удалить эту группу, вам необходимо назначить другую группу «по умолчанию».',
'Add group heading' 			 => 'Добавление новой группы (унаследует права той группы, на основе которой будет создаваться)',
'Add group legend'  			 => 'Добавить новую группу',
'Edit group heading'			 => 'Редактирование существующей группы',
'Base new group label'  		 => 'Базовая группа',
'Add group' 					 => 'Добавить новую группу',
'Default group heading' 		 => 'Группа «по умолчанию» для новых пользователей (администраторские и модераторские группы недоступны по соображениям безопасности)',
'Default group legend'  		 => 'Назначить группу «по умолчанию» для новых пользователей',
'Default group label'   		 => 'Группа «по умолчанию»',
'Set default'   				 => 'Назначить группу',
'Existing groups heading'   	 => 'Существующие группы',
'Existing groups intro'				=>	'Предопределённые группы «Гости» и «Администраторы» не могут быть удалены, но их можно отредактировать. Помните, что в некоторых группах определённые настройки недоступны (например, право на редактирование сообщений для гостей). Администраторы всегда имеют полные права.',
'Group removed' 				 => 'Группа удалена.',
'Default group set' 			 => 'Группа «по умолчанию» назначена.',
'Group added'   				 => 'Группа добавлена.',
'Group edited'  				 => 'Группа отредактирована.',
'Update group'  				 => 'Отправить',
'Must enter group message'  	 => 'Необходимо ввести название группы.',
'Already a group message'   	 => 'Группа <strong>«%s»</strong> уже существует.',
'Moderator default group'   	 => 'Это группа «по умолчанию» для новых пользователей, она не должна содержать прав модератора.',
);
