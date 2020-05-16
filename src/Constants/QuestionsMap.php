<?php

namespace App\Constants;

final class QuestionsMap
{
    const WORK_MEDICAL_FIELD_KEY = 'work-medical-field';
    const WORK_MEDICAL_FIELD_SCORE = 2;

    const CONTACTED_CONFIRMED_CASE_KEY = 'contact-confirmed-case';
    const CONTACTED_CONFIRMED_CASE_SCORE = 3;

    const TEMPERATURE_KEY = 'temperature';
    const TEMPERATURE_SCORE = 2;

    const BODY_CHECK_KEY = 'body-check';
    const BODY_CHECK_SCORE = 0;

    const COUGH_KEY = 'cough';
    const COUGH_SCORE = 3;

    const SORE_THROAT_KEY = 'sore-throat';
    const SORE_THROAT_SCORE = 1;

    const TRAVEL_ABROAD_KEY = 'travel-abroad';
    const TRAVEL_ABROAD_SCORE = 5;

    const CHRONIC_PEOPLE_KEY = 'chronic-people';
    const CHRONIC_PEOPLE_SCORE = 4;

    const IS_CHRONIC_KEY = 'isChronic';
    const IS_CHRONIC_SCORE = 1;

    public static function getQuestionsScores ()
    {
        return [
            self::WORK_MEDICAL_FIELD_KEY => self::WORK_MEDICAL_FIELD_SCORE,
            self::CONTACTED_CONFIRMED_CASE_KEY => self::CONTACTED_CONFIRMED_CASE_SCORE,
            self::TEMPERATURE_KEY => self::TEMPERATURE_SCORE,
//            self::BODY_CHECK_KEY => self::BODY_CHECK_SCORE,
            self::COUGH_KEY => self::COUGH_SCORE,
            self::SORE_THROAT_KEY => self::SORE_THROAT_SCORE,
            self::TRAVEL_ABROAD_KEY => self::TRAVEL_ABROAD_SCORE,
            self::CHRONIC_PEOPLE_KEY => self::CHRONIC_PEOPLE_SCORE,
            self::IS_CHRONIC_KEY => self::IS_CHRONIC_SCORE
        ];
    }
}