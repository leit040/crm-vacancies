<?php

declare(strict_types=1);

namespace App\Form;

/**
 * @OA\Schema(
 *     required={"url","count", "responseCount"},
 *     title="Create TestTask form"
 * )
 */
final class VacancyPublicationCreateForm extends \App\Model\BaseModel
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
    public int $viewsCount = 0;

    /**
     * @OA\Property(
     *     format="integer",
     * )
     */
    public int $responseCount = 0;

    public function rules(): array
    {
        return [
            [['url'], 'required'],
            [['url'], 'url'],
            [['viewsCount', 'responseCount'], 'integer'],
        ];
    }
}
