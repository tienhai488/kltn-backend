<?php

namespace App\Rules;

use App\Enum\VolunteerStatus;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckRegistedUser implements ValidationRule
{
    public function __construct(
        protected $projectId
    ) {
        //
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->projectId) {
            return;
        }

        if ($value) {
            $exists = \App\Models\Volunteer::where([
                ['user_id', $value],
                ['project_id', $this->projectId],
                ['status', '!=', VolunteerStatus::CANCELED->value]
            ])->exists();

            if ($exists) {
                $fail('Đã đăng kí tình nguyện viên ở dự án này.');
            }
        }
    }
}