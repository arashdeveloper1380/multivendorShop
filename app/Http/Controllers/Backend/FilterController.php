<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\Filter;
use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;

class FilterController extends Controller
{

    public function filter($id)
    {
        $Category = Category::findOrFail($id);
        $Filter = Filter::with('getChild')->where(['category_id'=>$id, 'parent_id'=>0])->get();
        $item = Item::getCategoryItem($id);

        return view('admin.filter.filter',compact('Category','Filter','item'));
    }

    public function add_filter(Request $request, $category_id)
    {
        $ّFilter = $request->get('filter');
        $childFilter = $request->get('child_filter');
        $itemValue = $request->get('item_id');
        Filter::addFilter($ّFilter, $childFilter, $category_id,$itemValue);

        return redirect()->back()->with('success','با موفقیت ثبت شد');
    }

    public function destroy($id)
    {
        $Filter = Filter::findOrFail($id);
        $Filter->getChild()->delete();
        $Filter->delete();

        return redirect()->back()->with('danger','با موفقیت حذف شد');
    }
}
