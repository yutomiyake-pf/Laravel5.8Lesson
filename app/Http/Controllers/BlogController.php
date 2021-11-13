<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Http\Requests\BlogRequest;

class BlogController extends Controller
{
    /**
     * ブログ一覧
     *
     * @return view
     */
    public function showList() {
        $blogs = Blog::all();

        return view('blog.list',[
            'blogs' => $blogs
        ]);
    }


    /**
     * ブログ詳細
     * @param int $id
     * @return view
     */
    public function showDetail($id) {
        $blog = Blog::find($id);

        if (!$blog) {
            \Session::flash('err_msg','データがありません');
            return redirect(route('blogs'));
        }

        return view('blog.detail',[
            'blog' => $blog
        ]);
    }

    /**
     * ブログ登録
     *
     * @return view
     */
    public function showCreate() {
        return view('blog.form');
    }

    /**
     * 登録処理
     *
     * @return view
     */
    public function exeStore(BlogRequest $request) {

        $inputs = $request->all();

        \DB::beginTransaction();
        try {
            Blog::create($inputs);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        \Session::flash('err_msg','ブログを登録しました');
        return redirect(route('blogs'));
    }

    /**
     * ブログ編集フォーム
     *
     * @return view
     */
    public function showEdit($id) {
        $blog = Blog::find($id);

        if (!$blog) {
            \Session::flash('err_msg','データがありません');
            return redirect(route('blogs'));
        }

        return view('blog.edit',[
            'blog' => $blog
        ]);
    }


    public function exeUpdate(BlogRequest $request) {

        $inputs = $request->all();

        \DB::beginTransaction();
        try {
            $blog = Blog::find($inputs['id']);
            $blog->fill([
                'title' => $inputs['title'],
                'content' => $inputs['content']
            ]);
            $blog->save();
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        \Session::flash('err_msg','ブログを更新しました');
        return redirect(route('blogs'));
    }

    public function exeDelete($id) {
        if (!$id) {
            \Session::flash('err_msg','データがありません');
            return redirect(route('blogs'));
        }

        try {
            Blog::destroy($id);
        } catch(\Throwable $e) {
            abort(500);
        }

        \Session::flash('err_msg','削除されました');
        return redirect(route('blogs'));
    }
}
