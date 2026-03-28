<?php

namespace console\controllers;

use common\services\TranslatorGeneratorService;
use Yii;
use yii\base\Module;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Exception;

/**
 * Команды:
 *     docker-compose exec backend php yii translator-generate/generate [100]
 */
class TranslatorGenerateController extends Controller
{
    /** @var TranslatorGeneratorService */
    private TranslatorGeneratorService $generatorService;

    public function init()
    {
        parent::init();
        $this->generatorService = Yii::$app->get('translatorGenerator');
    }

    /**
     * Генерация переводчиков: docker-compose exec backend php yii translator-generate/generate [100]
     *
     * @param int $count количество переводчиков (по умолчанию 100)
     * @return int
     * @throws Exception
     */
    public function actionCreate(int $count = 100): int
    {
        $this->stdout("Начало генерации $count переводчиков...\n");
        $created = $this->generatorService->generate($count);
        $this->stdout("Успешно создано: $created переводчиков\n");
        $this->stdout("Генерация завершена.\n");
        return ExitCode::OK;
    }
}
