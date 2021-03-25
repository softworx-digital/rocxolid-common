<?php

namespace Softworx\RocXolid\Common\Http\Controllers\AttributeModel;

// rocXolid utils
use Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse;
// rocXolid common repositories
use Softworx\RocXolid\Common\Repositories\AttributeModel\Repository as AttributeModelRepository;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Contracts\Attributable;
use Softworx\RocXolid\Common\Models\AttributeGroup;
// rocXolid common components
use Softworx\RocXolid\Common\Components\ModelViewers\AttributeModelViewer;

/**
 * @todo revise
 */
class Controller extends AbstractCrudController
{
    protected static $model_viewer_type = AttributeModelViewer::class;

    protected $form_mapping = [
        'general' => 'general',
    ];

    /**
     * @var \Softworx\RocXolid\Common\Models\Contracts\Attributable Reference to requested Attributable model.
     */
    private $attributable_model;

    /**
     * @var \Softworx\RocXolid\Common\Models\AttributeGroup Reference to requested AttributeGroup.
     */
    private $attribute_group;

    /**
     * Constructor.
     *
     * @param \Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse $response
     * @param \Softworx\RocXolid\Common\Repositories\AttributeModel\Repository $repository
     * @param \Softworx\RocXolid\Common\Models\Contracts\Attributable $attributable_model
     * @param \Softworx\RocXolid\Common\Models\AttributeGroup $attribute_group
     */
    public function __construct(AjaxResponse $response, AttributeModelRepository $repository, Attributable $attributable_model, AttributeGroup $attribute_group)
    {
        $this
            ->setAttributableModel($attributable_model)
            ->setAttributeGroup($attribute_group);

        $repository->setAttributeGroup($attribute_group);

        parent::__construct($response, $repository);
    }

    /**
     * Set reference to requested Attributable model.
     *
     * @param \Softworx\RocXolid\Common\Models\Contracts\Attributable $attributable_model Reference to requested Attributable model.
     *
     * @return self
     */
    public function setAttributableModel(Attributable $attributable_model): self
    {
        $this->attributable_model = $attributable_model;

        return $this;
    }

    /**
     * Get reference to requested Attributable model.
     *
     * @return \Softworx\RocXolid\Common\Models\Contracts\Attributable
     */
    public function getAttributableModel()
    {
        return $this->attributable_model;
    }

    /**
     * Set reference to requested AttributeGroup.
     *
     * @param \Softworx\RocXolid\Common\Models\AttributeGroup $attribute_group Reference to requested AttributeGroup.
     *
     * @return self
     */
    public function setAttributeGroup(AttributeGroup $attribute_group): self
    {
        $this->attribute_group = $attribute_group;

        return $this;
    }

    /**
     * Get reference to requested AttributeGroup.
     *
     * @return  \Softworx\RocXolid\Common\Models\AttributeGroup
     */
    public function getAttributeGroup()
    {
        return $this->attribute_group;
    }
}
