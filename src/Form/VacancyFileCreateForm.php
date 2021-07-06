<?php

declare(strict_types=1);

namespace App\Form;

/**
 * @OA\Schema(
 *     required={"VacancyId", "path","fileName"},
 *     title="Create VacancyFile form"
 * )
 */
final class VacancyFileCreateForm extends \App\Model\BaseModel
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
            [['VacancyId'], 'string', 'max' => 36],
            [['path', 'fileName'], 'string', 'max' => 1024],
        ];
    }
}
