<?php

namespace App\Admin\Controllers;

use App\Models\GoodModule;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;

class GoodModuleController
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('模块管理')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Edit interface.
     *
     * @param int     $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('模块编辑')
            ->description('编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('添加模块')
            ->description('创建')
            ->body($this->form());
    }

    public function show($id, Content $content)
    {
        return $content
            ->header('Config')
            ->description('detail')
            ->body(Admin::show(GoodModule::findOrFail($id), function (Show $show) {
                $show->id();
                $show->name();
                $show->created_at();
                $show->updated_at();
            }));
    }

    public function grid()
    {
        $grid = new Grid(new GoodModule());

        $grid->id('ID');
        $grid->name('模块名称');
        $grid->sort('排序');

        $grid->created_at('创建时间');
//        $grid->updated_at();

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->like('name');
        });

        return $grid;
    }

    public function form()
    {
        $form = new Form(new GoodModule());

//        $form->display('id', 'ID');
        $form->text('name','类别名称')->rules('required');
        $form->text('sort','排序');

//        $form->display('created_at');
//        $form->display('updated_at');

        return $form;
    }
}
