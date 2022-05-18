<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $link = [
            'https://flix.teamprojectx.xyz//asset/video/test_video.mp4',
            'https://flix.teamprojectx.xyz//asset/video/test_video.mp4',
            'https://flix.teamprojectx.xyz//asset/video/test_video.mp4',
            'https://flix.teamprojectx.xyz//asset/video/test_video.mp4',
            'https://flix.teamprojectx.xyz//asset/video/test_video.mp4',
            'https://flix.teamprojectx.xyz//asset/video/test_video.mp4',
            'https://flix.teamprojectx.xyz//asset/video/test_video.mp4',
            'https://flix.teamprojectx.xyz//asset/video/test_video.mp4',
            'https://flix.teamprojectx.xyz//asset/video/test_video.mp4',
            'https://flix.teamprojectx.xyz//asset/video/test_video.mp4',
            'https://flix.teamprojectx.xyz//asset/video/test_video.mp4',
        ];

        foreach ($link as $video){
            File::create([
                              'user_id'=>User::all()->random()->id,
                              'video'=> $video,
                              'privacy'=> 'public',
                          ]);
        }





    }
}
