namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Item;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Item $item)
    {
        $user = auth()->user();

        // Check if already liked
        $existing = Like::where('user_id', $user->id)
                        ->where('item_id', $item->id)
                        ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['liked' => false]);
        }

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id
        ]);

        return response()->json(['liked' => true]);
    }
}
