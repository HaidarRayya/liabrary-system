<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;

class DueDate implements ValidationRule
{
    private  $borrowsRecord;
    public function __construct($borrowsRecord)
    {
        $this->borrowsRecord = $borrowsRecord;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            if (Carbon::createFromFormat('Y-m-d H:i:s', $value)->lessThanOrEqualTo(Carbon::create($this->borrowsRecord->borrowed_at))) {
                $fail('لا يمكن ان يكون تاريخ الاعادة اقل من تاريخ الاستعارة');
            }
        } catch (Exception $e) {
        }
    }
}
