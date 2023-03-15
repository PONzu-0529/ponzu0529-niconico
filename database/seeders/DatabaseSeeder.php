<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Authentication;
use App\Models\IpAddress;
use App\Models\IpAddressAuthentication;
use App\Models\Music;
use App\Models\User;
use App\Models\Constants\AuthenticationConstant;
use App\Models\Constants\IpAddressAuthenticationConstant;
use App\Models\Constants\MusicConstant;
use App\Constants\AuthenticationLevelConstant;
use App\Constants\CommandLogConstant;
use App\Constants\IpAddressConstant;
use App\Constants\MylistAssistantConstant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::create([
            'name' => 'User1',
            'email' => 'test1@sample.com',
            'password' => bcrypt('password')
        ]);
        User::create([
            'name' => 'User2',
            'email' => 'test2@sample.com',
            'password' => bcrypt('password')
        ]);
        User::create([
            'name' => 'User3',
            'email' => 'test3@sample.com',
            'password' => bcrypt('password')
        ]);
        User::create([
            'name' => 'User4',
            'email' => 'test4@sample.com',
            'password' => bcrypt('password')
        ]);

        Authentication::truncate();
        Authentication::create([
            AuthenticationConstant::USER_ID => '1',
            AuthenticationConstant::FUNCTION_ID => MylistAssistantConstant::FUNCTION_ID,
            AuthenticationConstant::AUTHENTICATION_LEVEL => AuthenticationLevelConstant::VIEW
        ]);
        Authentication::create([
            AuthenticationConstant::USER_ID => '1',
            AuthenticationConstant::FUNCTION_ID => MylistAssistantConstant::FUNCTION_ID,
            AuthenticationConstant::AUTHENTICATION_LEVEL => AuthenticationLevelConstant::EDIT
        ]);
        Authentication::create([
            AuthenticationConstant::USER_ID => '1',
            AuthenticationConstant::FUNCTION_ID => MylistAssistantConstant::FUNCTION_ID,
            AuthenticationConstant::AUTHENTICATION_LEVEL => AuthenticationLevelConstant::MASTER_EDIT
        ]);
        Authentication::create([
            AuthenticationConstant::USER_ID => '2',
            AuthenticationConstant::FUNCTION_ID => MylistAssistantConstant::FUNCTION_ID,
            AuthenticationConstant::AUTHENTICATION_LEVEL => AuthenticationLevelConstant::VIEW
        ]);
        Authentication::create([
            AuthenticationConstant::USER_ID => '2',
            AuthenticationConstant::FUNCTION_ID => MylistAssistantConstant::FUNCTION_ID,
            AuthenticationConstant::AUTHENTICATION_LEVEL => AuthenticationLevelConstant::EDIT
        ]);
        Authentication::create([
            AuthenticationConstant::USER_ID => '3',
            AuthenticationConstant::FUNCTION_ID => MylistAssistantConstant::FUNCTION_ID,
            AuthenticationConstant::AUTHENTICATION_LEVEL => AuthenticationLevelConstant::VIEW
        ]);

        IpAddress::truncate();
        IpAddress::create([
            IpAddressConstant::IP_ADDRESS => '127.0.0.1',
            IpAddressConstant::MEMO => 'local'
        ]);

        IpAddressAuthentication::truncate();
        IpAddressAuthentication::create([
            IpAddressAuthenticationConstant::FUNCTION_ID => CommandLogConstant::FUNCTION_ID,
            IpAddressAuthenticationConstant::IP_ADDRESSE_ID => 1
        ]);

        Music::truncate();
        Music::create([
            MusicConstant::TITLE => 'Title1',
            MusicConstant::NICONICO_ID => 'NiconicoID1'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title2',
            MusicConstant::NICONICO_ID => 'NiconicoID2'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title3',
            MusicConstant::NICONICO_ID => 'NiconicoID3'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title4',
            MusicConstant::NICONICO_ID => 'NiconicoID4'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title5',
            MusicConstant::NICONICO_ID => 'NiconicoID5'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title6',
            MusicConstant::NICONICO_ID => 'NiconicoID6'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title7',
            MusicConstant::NICONICO_ID => 'NiconicoID7'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title8',
            MusicConstant::NICONICO_ID => 'NiconicoID8'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title9',
            MusicConstant::NICONICO_ID => 'NiconicoID9'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title10',
            MusicConstant::NICONICO_ID => 'NiconicoID10'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title11',
            MusicConstant::NICONICO_ID => 'NiconicoID11'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title12',
            MusicConstant::NICONICO_ID => 'NiconicoID12'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title13',
            MusicConstant::NICONICO_ID => 'NiconicoID13'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title14',
            MusicConstant::NICONICO_ID => 'NiconicoID14'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title15',
            MusicConstant::NICONICO_ID => 'NiconicoID15'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title16',
            MusicConstant::NICONICO_ID => 'NiconicoID16'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title17',
            MusicConstant::NICONICO_ID => 'NiconicoID17'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title18',
            MusicConstant::NICONICO_ID => 'NiconicoID18'
        ]);
        Music::create([
            MusicConstant::TITLE => 'Title19',
            MusicConstant::NICONICO_ID => 'NiconicoID19'
        ]);
    }
}
