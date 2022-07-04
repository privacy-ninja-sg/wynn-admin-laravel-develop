<?php
\URL::forceScheme(env('FORCE_HTTPS', 'http'));
Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    // Route::get('users/detail');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Deposit Withdraw Transaction
    Route::delete('deposit-withdraw-transactions/destroy', 'DepositWithdrawTransactionController@massDestroy')->name('deposit-withdraw-transactions.massDestroy');
    Route::resource('deposit-withdraw-transactions', 'DepositWithdrawTransactionController');

    // Deposit
    Route::delete('deposits/destroy', 'DepositController@massDestroy')->name('deposits.massDestroy');
    Route::resource('deposits', 'DepositController');

    // Withdraw
    Route::delete('withdraws/destroy', 'WithdrawController@massDestroy')->name('withdraws.massDestroy');
    Route::resource('withdraws', 'WithdrawController');
    Route::post('withdraws/updatestatus', 'WithdrawController@updateStatus')->name('withdraws.update.status');

    // Game
    Route::delete('games/destroy', 'GameController@massDestroy')->name('games.massDestroy');
    Route::resource('games', 'GameController');

    // Customer
    Route::delete('customers/destroy', 'CustomerController@massDestroy')->name('customers.massDestroy');
    Route::resource('customers', 'CustomerController');

    // Bank
    Route::delete('banks/destroy', 'BankController@massDestroy')->name('banks.massDestroy');
    Route::resource('banks', 'BankController');

    // Bank Account
    Route::delete('bank-accounts/destroy', 'BankAccountController@massDestroy')->name('bank-accounts.massDestroy');
    Route::resource('bank-accounts', 'BankAccountController');

    // Channel
    Route::delete('channels/destroy', 'ChannelController@massDestroy')->name('channels.massDestroy');
    Route::resource('channels', 'ChannelController');

    // Game Account
    Route::delete('game-accounts/destroy', 'GameAccountController@massDestroy')->name('game-accounts.massDestroy');
    Route::resource('game-accounts', 'GameAccountController');

    // Game Transfer
    Route::delete('game-transfers/destroy', 'GameTransferController@massDestroy')->name('game-transfers.massDestroy');
    Route::resource('game-transfers', 'GameTransferController');

    // Line Account
    Route::delete('line-accounts/destroy', 'LineAccountController@massDestroy')->name('line-accounts.massDestroy');
    Route::resource('line-accounts', 'LineAccountController');

    // Pg Slot Account
    Route::delete('pg-slot-accounts/destroy', 'PgSlotAccountController@massDestroy')->name('pg-slot-accounts.massDestroy');
    Route::resource('pg-slot-accounts', 'PgSlotAccountController');

    // Pretty Game Account
    Route::delete('pretty-game-accounts/destroy', 'PrettyGameAccountController@massDestroy')->name('pretty-game-accounts.massDestroy');
    Route::resource('pretty-game-accounts', 'PrettyGameAccountController');

    // Sa Game Account
    Route::delete('sa-game-accounts/destroy', 'SaGameAccountController@massDestroy')->name('sa-game-accounts.massDestroy');
    Route::resource('sa-game-accounts', 'SaGameAccountController');

    // Transfer Transaction
    Route::delete('transfer-transactions/destroy', 'TransferTransactionController@massDestroy')->name('transfer-transactions.massDestroy');
    Route::resource('transfer-transactions', 'TransferTransactionController');

    // Wallet Credit
    Route::delete('wallet-credits/destroy', 'WalletCreditController@massDestroy')->name('wallet-credits.massDestroy');
    // Route::resource('wallet-credits', 'WalletCreditController');
    Route::get('wallet-credits', 'WalletCreditController@index')->name('wallet-credits.index');
    Route::any('wallet-credits/add-credit', 'WalletCreditController@addCredit')->name('wallet-credits.addCredit');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
