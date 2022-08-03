<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Bride;
use App\Models\Groom;
use App\Models\Image;
use App\Models\InvitedGuest;
use App\Models\Location;
use App\Models\LoveStory;
use App\Models\UndanganMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UndanganController extends Controller
{
    protected $member;
    protected $undangan;
    public function __construct()
    {
        $this->member = auth('users')->user();
        // get one undangan where user_id = $this->member->id
        // $this->undangan = UndanganMaster::where('user_id', $this->member->id)->first();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return all Undangan
        return response()->json(UndanganMaster::with(['bride', 'groom', 'agenda', 'love_story','invited_guest'])->where('user_id', $this->member->id)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the request
        $validator = Validator::make($request->all(), [
            'nickname_groom' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $undangan = UndanganMaster::where('user_id', $this->member->id)->first();
        // check groom
        $hasGroom = Groom::where('undangan_id', $undangan->id)->first();
        $hasBride = Bride::where('undangan_id', $undangan->id)->first();
        if (!$hasGroom && !$hasBride) {
            # code...
            $groomCreate = $this->groomCreate($request, $undangan->id);
            $brideCreate = $this->brideCreate($request, $undangan->id);
            if ($groomCreate && $brideCreate) {
                return response()->json(['message' => 'success'], 200);
            } else {
                return response()->json(['message' => 'failed'], 400);
            }
        }

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function agendaCreate(Request $request)
    {
        $undangan = UndanganMaster::where('user_id', $this->member->id)->first();
        $data = [];
        foreach ($request->title as $key => $title) {
            $data[] = [
                'title' => $title,
                'date' => $request->date[$key],
                'time_start' => $request->time_start[$key],
                'time_end' => $request->time_end[$key],
                'place' => $request->place[$key],
                'location' => $request->location[$key],
                'undangan_id' => $undangan->id,
            ];
        }
        $agenda = Agenda::insert($data);
        if (!$agenda) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan agenda',
            ], 400);
        }
        return response()->json([
            'success' => true,
        ]);
    }

    // create location
    public function locationCreate(Request $request)
    {
        $undangan = UndanganMaster::where('user_id', $this->member->id)->first();
        $location = Location::create([
            'google_map_link' => $request->google_map_link,
            'undangan_id' => $undangan->id,
        ]);
        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan location',
            ], 400);
        }
        return response()->json([
            'success' => true,
        ]);
    }

    // create love story
    public function loveStoryCreate(Request $request)
    {
        $undangan = UndanganMaster::where('user_id', $this->member->id)->first();
        $data = [];
        foreach ($request->title_story as $key => $title_story) {

            if ($request->image_story[$key]) {
                // $title_story replace space with underscore and lowercase
                $fileName = str_replace(' ', '_', $title_story);
                // $filename to lowercase
                $fileName = strtolower($fileName);
                $fileName = $fileName . '_' . time();
                $image = $request->image_story[$key]->storeOnCloudinaryAs('love-story', $fileName)->getSecurePath();
            } else {
                $image = null;
            }
            $data[] = [
                'title' => $title_story,
                'content' => $request->content_story[$key],
                'place' => $request->place_story[$key],
                'date' => $request->date_story[$key],
                'image_url' => $image,
                'undangan_id' => $undangan->id,
            ];
        }
        $love_story = LoveStory::insert($data);
        if (!$love_story) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan love story',
            ], 400);
        }
        return response()->json([
            'success' => true,
        ]);
        return response()->json([
            'data' => $data,
        ]);
    }

    // create galery
    public function galeryCreate(Request $request)
    {
        $undangan = UndanganMaster::where('user_id', $this->member->id)->first();
        if ($request->hasFile('galery')) {
            foreach ($request->galery as $image) {
                $image = $image->storeOnCloudinaryAs('galery')->getSecurePath();
                $data[] = [
                    'url' => $image,
                    'undangan_id' => $undangan->id,
                ];
            }

            // insert galery
            $galery = Image::insert($data);
            if (!$galery) {
                return response()->json([
                    'success' => false,
                    'error' => 'Error inserting galery image '
                ]);
            }
            return response()->json([' galery' => $galery]);
        }
    }

    // create invited_guest
    public function inviteGuest(Request $request)
    {
        $undangan = UndanganMaster::where('user_id', $this->member->id)->first();

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 3; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $slug = strtolower(str_replace(' ', '-', $request->guest_name)) . '_' . $randomString;

        $data = [
            'undangan_id' => $undangan->id,
            'name' => $request->guest_name,
            'address' => $request->guest_address,
            'telephone_number' => $request->guest_telephone_number,
            'email_address' => $request->guest_email_address,
            'slug' => $slug,
        ];
        $invited_guest = InvitedGuest::create($data);

        return response()->json([
            'data' => $invited_guest,
        ]);
    }
    
    // create video
    public function videoCreate(Request $request)
    {
        $undangan = UndanganMaster::where('user_id', $this->member->id)->first();
        $data = [
            'url'=> $request->youtube_url,
            'zoom_url'=> $request->zoom_url,
        ];
    }


    private function groomCreate($request, $id)
    {
        $data = [
            'undangan_id' => $id,
            'nickname' => $request->nickname_groom,
            'name' => $request->name_groom,
            'parents_name' => $request->parents_groom,
            'address' => $request->address_groom,
            'other_info' => $request->other_info_groom,
            'facebook_link' => $request->facebook_link_groom,
            'instagram_link' => $request->instagram_link_groom,
            'twitter_link' => $request->twitter_link_groom,
            'tiktok_link' => $request->tiktok_link_groom,
        ];
        $groom = Groom::create($data);
    }
    private function brideCreate($request, $id)
    {
        $data = [
            'undangan_id' => $id,
            'nickname' => $request->nickname_bride,
            'name' => $request->name_bride,
            'parents_name' => $request->parents_bride,
            'address' => $request->address_bride,
            'other_info' => $request->other_info_bride,
            'facebook_link' => $request->facebook_link_bride,
            'instagram_link' => $request->instagram_link_bride,
            'twitter_link' => $request->twitter_link_bride,
            'tiktok_link' => $request->tiktok_link_bride,
        ];
        $bride = Bride::create($data);
    }
}
