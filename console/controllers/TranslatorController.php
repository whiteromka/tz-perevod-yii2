<?php

namespace console\controllers;

use common\services\TranslatorGeneratorService;
use yii\base\Module;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Exception;

/**
 * Команды:
 *     docker-compose exec backend php yii translator/generate [100]
 */
class TranslatorController extends Controller
{
    /** @var TranslatorGeneratorService */
    private TranslatorGeneratorService $generatorService;

    /**
     * @param string $id
     * @param Module $module
     * @param TranslatorGeneratorService $generatorService
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        TranslatorGeneratorService $generatorService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->generatorService = $generatorService;
    }

    /**
     * Генерация переводчиков: docker-compose exec backend php yii translator/generate [100]
     *
     * @param int $count количество переводчиков (по умолчанию 100)
     * @return int
     * @throws Exception
     */
    public function actionGenerate(int $count = 100): int
    {
        $this->stdout("Начало генерации $count переводчиков...\n");
        $created = $this->generatorService->generate($count);
        $this->stdout("Успешно создано: $created переводчиков\n");
        $this->stdout("Генерация завершена.\n");
        return ExitCode::OK;
    }
}
