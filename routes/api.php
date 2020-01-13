<?php

Route::group([
    'prefix' => 'users',
], function () {
    Route::get('/{id}', 'UserController@getById');
    Route::post('/register', 'UserController@register');
    Route::put('/{id}/update', 'UserController@update');
    Route::delete('/{id}', 'UserController@delete');
    Route::get('/{id}/followers', 'UserController@paginateFollowersByUserId');
    Route::get('/{id}/followings', 'UserController@paginateFollowingsByUserId');
    Route::get('/{id}/tweets', 'TweetController@paginateByUserId');
    Route::get('/{id}/chats', 'ChatController@paginateChatsByUserId');
    Route::put('/{id}/follow', 'UserController@followOrUnfollow');
});

Route::group([
    'prefix' => 'tweets',
], function () {
    Route::get('/', 'TweetController@paginate');
    Route::get('/{id}', 'TweetController@getById');
    Route::get('/{id}/likes', 'UserController@paginateUsersWhoLikedByTweetId');
    Route::post('/post', 'TweetController@create');
    Route::delete('/{id}', 'TweetController@delete');
    Route::put('/{id}/like', 'TweetController@likeOrUnlikeTweet');
});

Route::group([
    'prefix' => 'polls'
], function () {
    Route::put('/{id}/vote', 'PollController@voteOrRetract');
    Route::put('/{id}/close', 'PollController@close');
});

Route::group([
    'prefix' => 'chats'
], function () {
    Route::post('/create', 'ChatController@create');
    Route::delete('/{id}', 'ChatController@delete');
    Route::get('/{id}/messages', 'MessageController@paginateMessagesByChatId');
});

Route::group([
    'prefix' => 'messages'
], function () {
    Route::post('/send', 'MessageController@send');
    Route::put('/{id}/read', 'MessageController@read');
    Route::delete('/{id}', 'MessageController@delete');
});

Route::group([
    'prefix' => 'lists'
], function () {
    Route::get('/{id}/tweets', 'TweetController@paginateByListId');
    Route::get('/{id}', 'ListController@getById');
    Route::get('/ownerships/{user_id}', 'ListController@paginateByOwnerId');
    Route::get('/subscriptions/{user_id}', 'ListController@paginateBySubscriberId');
    Route::get('/memberships/{user_id}', 'ListController@paginateByMemberId');
    Route::get('/{id}/subscribers', 'UserController@paginateSubscribersByListId');
    Route::get('/{id}/members', 'UserController@paginateMembersByListId');
    Route::post('/create', 'ListController@create');
    Route::put('/{id}/add/subscriber', 'ListController@addSubscriber');
    Route::put('/{id}/add/member', 'ListController@addMember');
    Route::put('/{id}/update', 'ListController@update');
    Route::delete('/{id}', 'ListController@delete');
    Route::put('/{id}/remove/subscriber', 'ListController@removeSubscriber');
    Route::put('/{id}/remove/member', 'ListController@removeMember');
});


