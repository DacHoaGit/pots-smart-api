<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestionController extends Controller
{   
    public function getSuggestions(){
        try {
            $suggestions = Suggestion::orderByDesc('created_at')->get();
            return response()->json($suggestions, 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong in PostController.store',
                'error' => $e->getMessage()
            ], 400);
        }
    }
    public function store(Request $request)
    {
        try {

            $suggestion = new Suggestion();
           

            $suggestion->name = $request->get('name');
            $suggestion->user_id = Auth::user()->id;
            $suggestion->description = $request->get('description');

            $suggestion->nhiet_do_bom_min = $request->get('nhiet_do_bom_min');
            $suggestion->nhiet_do_bom_max = $request->get('nhiet_do_bom_max');
            $suggestion->do_am_khong_khi_bom_min = $request->get('do_am_khong_khi_bom_min');
            $suggestion->do_am_khong_khi_bom_max = $request->get('do_am_khong_khi_bom_max');
            $suggestion->do_am_dat_bom_min = $request->get('do_am_dat_bom_min');
            $suggestion->do_am_dat_bom_max = $request->get('do_am_dat_bom_max');
            $suggestion->nhiet_do_den_min = $request->get('nhiet_do_den_min');
            $suggestion->nhiet_do_den_max = $request->get('nhiet_do_den_max');
            $suggestion->do_am_khong_khi_den_min = $request->get('do_am_khong_khi_den_min');
            $suggestion->do_am_khong_khi_den_max = $request->get('do_am_khong_khi_den_max');
            $suggestion->do_am_dat_den_min = $request->get('do_am_dat_den_min');
            $suggestion->do_am_dat_den_max = $request->get('do_am_dat_den_max');

            if ($request->hasFile('image')) {
                (new ImageService)->updateImage($suggestion, $request, '/images/suggestions/', 'store');
                
            }
            
            $suggestion->save();
            return response()->json('New suggestion created', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in PostController.store',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy(int $id){
        try {
            
            $suggestion = Suggestion::where('id',$id)->where('user_id',Auth::user()->id)->first();
            
            if (!empty($suggestion->image)) {
                $currentImage = public_path() . '/images/suggestions/' . $suggestion->image;

                if (file_exists($currentImage)) {
                    unlink($currentImage);
                }
            }

            $suggestion->delete();

            return response()->json('Post deleted', 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong in SuggestionController.destroy',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
