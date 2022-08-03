<?php

namespace App\Http\Controllers;

use App\Models\UndanganMaster;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UndanganMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null)
    {
        if ($slug) {
            $undangan = UndanganMaster::with(['bride', 'groom', 'agenda', 'love_story'])->where('slug', $slug)->first();
            // if get invited guest where invited_guest.slug =$GET['guest'];
            if (isset($_GET['guest'])) {
                $undangan = UndanganMaster::with(['bride', 'groom', 'agenda', 'love_story', 'invited_guest' => function ($query) {
                    $query->where('slug', $_GET['guest']);
                }])->where('slug', $slug)->first();
            }
            // check if expired_date is less than now
            if (!$undangan) {
                return response()->json(['message' => 'Undangan tidak ditemukan'], 404);
            }
            if ($undangan->expired_date < now()) {
                return response()->json(['message' => 'Undangan sudah kadaluarsa'], 404);
            }
            return response()->json($undangan);
        }
    }

    public function checkSlug($slug = null)
    {
        // check if slug is exist
        $undangan = UndanganMaster::where('slug', $slug)->first();
        if ($undangan) {
            return response()->json(['message' => 'Slug sudah ada','code'=>400,'status'=>'invalid'], 200);
        }
        return response()->json(['message' => 'Slug tersedia','status'=>'success'], 200);

    }
}
