<?php

declare(strict_types=1);

namespace App\Form;

use App\Model\VacancyStatus;
use App\Model\VacancyType;
use yii\base\Model;

/**
 * @OA\Schema(
 *     required={"name","rate" ,"position","vacancyStatus", "assignTo","count","isRemote","description","vacancyType"},
 *     title="Create Candidate form"
 * )
 */
final class VacancyCreateForm extends \App\Model\BaseModel
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
    public string $name = '';
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
    public string $rate = '';

    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $vacancyStatus = '';

    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $assignTo = '';
    /**
     * @OA\Property(
     *     format="integer",
     * )
     */
    public int $count = 1;
    /**
     * @OA\Property(
     *     format="boolean",
     * )
     */
    public bool $isRemote = false;
    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $description = '';

    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $vacancyType = '';

    /**
     * @OA\Property(property="files", type="array", @OA\Items(ref="#/components/schemas/VacancyFileCreateForm")),
     * )
     */
    public array $files = [];

    /**
     * @OA\Property(property="publications", type="array", @OA\Items(ref="#/components/schemas/VacancyPublicationCreateForm")),
     * )
     */
    public array $publications = [];

    public function rules(): array
    {
        return [
            [['name', 'position', 'rate', 'vacancyStatus', 'vacancyType', 'assignTo', 'description', 'isRemote'], 'required'],
            [['id', 'assignTo'], 'string', 'max' => 36],
            ['vacancyStatus', 'in', 'range' => VacancyStatus::availableTypes()],
            ['vacancyType', 'in', 'range' => VacancyType::availableTypes()],
            [['position'], 'string', 'max' => 1024],
            [['files'], 'safe'],
            [['publications'], 'publicationsValidator'],
        ];
    }

    public function publicationsValidator($attribute, $params)
    {
        if (!Model::validateMultiple($this->publications)) {
            $this->addError('VacancyPublication', \Yii::t('app', 'Invalid input on VacancyPublication.'));
        }
    }
}
