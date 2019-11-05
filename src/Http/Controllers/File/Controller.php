<?php

namespace Softworx\RocXolid\Common\Http\Controllers\File;

use App;
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Components\Forms\FormField;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Models\File;
use Softworx\RocXolid\Common\Repositories\File\Repository;

/**
 *
 */
class Controller extends AbstractCrudController
{
    protected static $model_class = File::class;

    protected static $repository_class = Repository::class;

    public function get(CrudRequest $request, $id)
    {
        if ($file = File::find($id))
        {
            return response($file->content())
                ->header('Content-Type', $file->mime_type)
                ->header('Content-Disposition', sprintf('attachment; filename="%s"', $file->attachment_filename));
        }

        return null;
    }

    public function update(CrudRequest $request, $id)//: Response
    {
        $assignments = [];
        $repository = $this->getRepository($this->getRepositoryParam($request));

        $this->setModel($repository->find($id));

        $form = $repository->getForm($this->getFormParam($request));
        $form
            //->adjustUpdate($request)
            ->adjustUpdateBeforeSubmit($request)
            ->submit();

        if ($form->isValid())
        {
            $attribute = $this->getModel()->model_attribute;

            if ($request->has('_data.is_model_primary') && $request->input('_data.is_model_primary'))
            {
                $files = ($this->getModel()->parent->$attribute instanceof Collection) ? $this->getModel()->parent->$attribute : [ $this->getModel()->parent->$attribute ];

                foreach ($files as $file)
                {
                    $file->is_model_primary = 0;
                    $file->save();
                }
            }

            $repository->updateModel($form->getFormFieldsValues()->toArray(), $this->getModel(), 'update');

            $model_viewer_component = $this->getModelViewerComponent($this->getModel());

            $parent_controller = App::make($this->getModel()->parent->getControllerClass());
            $parent_controller->setModel($this->getModel()->parent);
            $parent_form = $parent_controller
                ->getRepository()
                ->getForm($parent_controller->getFormParam($request));
            $parent_form_field_component = (new FormField())->setFormField($parent_form->getFormField($this->getModel()->model_attribute));

            $this->getModel()->parent->load($this->getModel()->model_attribute);

            return $this->response
                ->replace($parent_form_field_component->makeDomId('files', $this->getModel()->model_attribute), $parent_form_field_component->fetch('include.files'))
                ->modalClose($model_viewer_component->makeDomId('modal-update'))
                ->get();
        }
        else
        {
            return $this->errorResponse($request, $repository, $form, 'edit');
        }
    }

    protected function destroyResponse(CrudRequest $request, CrudableModel $model)
    {
        if ($request->ajax())
        {
            return $this->response->redirect($model->parent->getControllerRoute('edit'))->get();
        }
        else
        {
            return redirect($model->parent->getControllerRoute('edit'));
        }
    }
}