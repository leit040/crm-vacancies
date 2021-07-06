<?php

declare(strict_types=1);

namespace App\Form;

/**
 * @OA\Schema(
 *     required={"testTaskId", "path","fileName"},
 *     title="Create TestTaskFile form"
 * )
 */
final class TestTaskFileCreateForm extends \App\Model\BaseModel
{
    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $id = '';

    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $path = '';

    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $fileName = '';

    public function rules(): array
    {
        return [
            [['path', 'fileName'], 'required'],
            [['testTaskId'], 'string', 'max' => 36],
            [['path', 'fileName'], 'string', 'max' => 1024],
        ];
    }
}
