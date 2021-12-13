<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function item($id)
    {
        $Category = Category::findOrFail($id);
        $Items = Item::with('getChild')->where(['category_id'=>$id,'parentId'=>0])
        ->orderBy('position','ASC')->get();
        return view('admin.item.index',compact('Category','Items'));
    }

    public function add_item(Request $request, $category_id)
    {
        $Items = $request->get('item',array());
        $childItems = $request->get('child_item',array());
        $checkedItem = $request->get('check_box_item',array());

        Item::addItem($Items, $childItems, $checkedItem, $category_id);

        return redirect()->back()->with('success','با موفقیت ثبت شد');
    }

    public function destroy($id)
    {
        $Item = Item::findOrFail($id);
        $Item->getChild()->delete();
        $Item->delete();

        return redirect()->back()->with('danger','با موفقیت حذف شد');
    }
}
