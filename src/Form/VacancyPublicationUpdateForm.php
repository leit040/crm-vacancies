<?php

declare(strict_types=1);

namespace App\Form;

/**
 * @OA\Schema(
 *     required={"id","url","count", "responseCount"},
 *     title="Update Vacancy Publication form"
 * )
 */
final class VacancyPublicationUpdateForm extends \App\Model\BaseModel
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
    public string $url = '';

    /**
     * @OA\Property(
     *     format="integer",
     * )
     */
    public int $count = 0;

    /**
     * @OA\Property(
     *     format="integer",
     * )
     */
    public int $responseCount = 0;

    public function rules(): array
    {
        return [
            [['id', 'url'], 'required'],
            [['url'], 'url'],
            [['count', 'responseCount'], 'int'],
        ];
    }
}
