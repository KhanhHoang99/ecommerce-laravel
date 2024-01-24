<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    //
    public function rate(Request $request)
    {
        try {
            
            $request->validate([
                'rate' => 'required',
                'id_blog' => 'required|exists:blogs,id',
            ]);
    
            $user = auth()->user();
    
           // Check nếu user đã rated blog
            $existingRating = Rate::where('id_user', $user->id)
            ->where('id_blog', $request->id_blog)
            ->first();

            if ($existingRating) {
                // nếu user đã rate => update rate
                $existingRating->update([
                    'rate' => $request->rate,
                ]);
            } else {
                // nếu user chưa rate
                Rate::create([
                    'rate' => $request->rate,
                    'id_blog' => $request->id_blog,
                    'id_user' => $user->id,
                ]);
            }
    
            return response()->json(['success' => true, 'message' => 'Rating saved successfully']);

        }catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error saving rating. ' . $e->getMessage()], 500);
        }
    }
}
