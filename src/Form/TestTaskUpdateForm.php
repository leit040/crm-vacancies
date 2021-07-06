<?php

declare(strict_types=1);

namespace App\Form;

/**
 * @OA\Schema(
 *     required={"position","briefId", "description"},
 *     title="Create TestTask form"
 * )
 */
final class TestTaskUpdateForm extends \App\Model\BaseModel
{
    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $position = '';

    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $briefId = '';

    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $description = '';

    /**
     * @OA\Property(property="files", type="array", @OA\Items(ref="#/components/schemas/TestTaskFileCreateForm")),
     * )
     */
    public array $files = [];

    public function rules(): array
    {
        return [
            [['position', 'briefId', 'description'], 'required'],
            [['briefId'], 'string', 'max' => 36],
            [['position'], 'string', 'max' => 1024],
        ];
    }
}
