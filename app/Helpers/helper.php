<?php
function mapItems($klausulItems , ...$includes)
{
    $items = [];
    foreach ($klausulItems as $klausulItem) {
        if ($klausulItem->parent_id === null) {
            $item = [
                'id' => $klausulItem->id,
                'title' => $klausulItem->title,
                'nilai' => [
                    'target' => $klausulItem->penilaians->first()->target,
                    'aktual' => $klausulItem->penilaians->first()->aktual,
                    'keterangan' => $klausulItem->penilaians->first()->keterangan,
                ],
            ];
            if(in_array('rekomendasi', $includes)){
                $item['nilai']['rekomendasi'] = $klausulItem->first()->rekomendasi;
            }
            
            $children = getChildren($klausulItem, $klausulItems, $includes);
            if (!empty($children)) {
                $item['children'] = $children;
            }
            $items[] = $item;
        }
    }
    return $items;
}

function getChildren($parent, $klausulItems, $attributes)
{
    $children = [];
    foreach ($klausulItems as $klausulItem) {
        if ($klausulItem->parent_id === $parent->id) {
            $item = [
                'id' => $klausulItem->id,
                'title' => $klausulItem->title,
                'nilai' => [
                    'target'  => $klausulItem->penilaians->first()->target,
                    'aktual'  => $klausulItem->penilaians->first()->aktual,
                    'keterangan' => $klausulItem->penilaians->first()->keterangan,
                ]
            ];

            if(in_array('rekomendasi', $attributes)){
                $item['nilai']['rekomendasi'] = $klausulItem->first()->rekomendasi;
            }

            $nestedChildren = getChildren($klausulItem, $klausulItems, $attributes);
            if (!empty($nestedChildren)) {
                $item['children'] = $nestedChildren;
            }
            $children[] = $item;
        }
    }
    return $children;
}
