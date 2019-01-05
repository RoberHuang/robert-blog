<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/*
 * 私有频道认证
 */
Broadcast::channel('tasks.{project}', function ($user, \App\Models\Admin\Project $project) {
    return $project->users()->contains($user);
});
