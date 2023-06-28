<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Firestore;

class FirestoreController extends Controller
{
    public function __construct(Firestore $firestore)
    {
        $this->firestore = $firestore;
    }
    public function index(){
        $firestore  = app('firebase.firestore');
        $db         = $firestore->database();
        $docRef     = $db->collection('users')->listDocuments();
        return response($docRef);

    }
}
