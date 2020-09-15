<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Shvorak\ProductAdditionalDescription\Ui\Component\Listing\Column;

/**
 * Class PageActions
 */
class PageActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Prepare Actions link
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        //TODO: Add Actions link to grid
        if (isset($dataSource["data"]["items"])) {
            foreach ($dataSource["data"]["items"] as & $item) {
                $name = $this->getData("name");
                $id = "X";
                if(isset($item["pulsestorm_todocrud_todoitem_id"]))
                {
                    $id = $item["pulsestorm_todocrud_todoitem_id"];
                }
                $item[$name]["view"] = [
                    "href"=>$this->getContext()->getUrl(
                        "pulsestorm_todo_listing/todoitem/edit",["pulsestorm_todocrud_todoitem_id"=>$id]),
                    "label"=>__("Edit")
                ];
            }
        }
        return $dataSource;
    }
}

