<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseController extends Controller
{
    //
    private $serviceAccount;
    private $firebase;

    public function __construct(){
        $this->serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/ramabet-dbb7f-firebase-adminsdk-rn5ws-4d81cc8e60.json');
        $this->firebase = (new Factory)
            ->withServiceAccount($this->serviceAccount)
            ->withDatabaseUri('https://ramabet-dbb7f.firebaseio.com')
            ->create();
    }
    public function index()
    {
        $database = $this->firebase->getDatabase();
        $data['type']='string';
        $data['value']='test';

        $newPost = $database
            ->getReference('test')/*->set('')*/
            ->set([
                'title' => $data ,
                'category' => 'Laravel'
            ]);
        echo '<pre>';
        print_r($newPost->getvalue());
    }
    public function runnerUpdate($data){
        $database = $this->firebase->getDatabase();
        $database
            ->getReference('runners')->set($data);
        //echo '<pre>';
        //print_r($newPost->getvalue());
    }
    public function userUpdate($id){
        $database = $this->firebase->getDatabase();
        $database
            ->getReference('users/'.$id)->set([
                'title' => 'users'
            ]);
        //echo '<pre>';
        //print_r($newPost->getvalue());
    }
    public function profit($id){
        $database = $this->firebase->getDatabase();
        $database
            ->getReference('profit/'.$id)->set([
                'title' => 'users'
            ]);
        //echo '<pre>';
        //print_r($newPost->getvalue());
    }
    public function updateEvent($date){
        $database = $this->firebase->getDatabase();
        $database
            ->getReference('Event/')->set($date);
        //echo '<pre>';
        //print_r($newPost->getvalue());
    }
    public function SendNotification($path,$date){
        $database = $this->firebase->getDatabase();
        $database->getReference($path)->set($date);
        //echo '<pre>';
        //print_r($newPost->getvalue());
    }
}
