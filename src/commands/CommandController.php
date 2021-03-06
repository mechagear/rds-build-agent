<?php
/**
 * @author Artem Naumenko
 */

namespace whotrades\RdsBuildAgent\commands;

class CommandController extends \whotrades\RdsSystem\commands\CommandController
{
    public $user;
    public $projectPath;
    public $package;
    public $workerName;

    /**
     * @param string $actionID
     * @return array
     */
    public function options($actionID)
    {
        return array_merge(parent::options($actionID), ['package', 'workerName']);
    }

    /**
     * @return array
     */
    public function getCommands()
    {
        $workerName = $this->workerName;

        return [
            "# Сборка $workerName",
            $this->createCommand(DeployController::class, 'index', [$workerName], "deploy_deploy_$workerName"),
            $this->createCommand(UseController::class, 'index', [$workerName], "deploy_use_$workerName"),
            $this->createCommand(KillerController::class, 'index', [$workerName], "deploy_killer_$workerName"),

            "# Обслуживание, удаление мусора и т.д.",
            $this->createCommand(GarbageCollectorController::class, 'index', [$workerName], "deploy_garbage_collector_$workerName", '* * * * * *'),

            "# Миграции $workerName",
            $this->createCommand(MigrationController::class, 'index', [$workerName], "deploy_migration_$workerName"),
        ];
    }
}
