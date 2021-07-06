<?php

declare(strict_types=1);

namespace App\Form;

use App\Model\CandidateStatusType;

/**
 * @OA\Schema(
 *     required={"id","candidateStatus","fullName" ,"position","phone", "socials","assignToId","vacancy_id","is_responded"},
 *     title="Create Candidate form"
 * )
 */
final class CandidateCreateForm extends \App\Model\BaseModel
{
    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $candidateStatus = '';
    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $fullName = '';
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
    public string $phone = '';

    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $socials = '';
    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $assignToId = '';
    /**
     * @OA\Property(
     *     format="string",
     * )
     */
    public string $vacancyId = '';
    /**
     * @OA\Property(
     *     format="boolean",
     * )
     */
    public bool $isResponded = false;

    /**
     * @OA\Property(property="files", type="array", @OA\Items(ref="#/components/schemas/CandidateFileCreateForm")),
     * )
     */
    public array $files = [];

    public function rules(): array
    {
        return [
            [['candidateStatus', 'fullName', 'position', 'phone', 'assignToId', 'vacancyId'], 'required'],
            [['assignToId', 'vacancyId'], 'string', 'max' => 36],
            ['candidateStatus', 'in', 'range' => CandidateStatusType::availableTypes()],
            [['position'], 'string', 'max' => 1024],
            [['files'], 'safe'],
        ];
    }
}
