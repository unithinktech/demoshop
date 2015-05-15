<?php

namespace SS6\ShopBundle\Command;

use SS6\ShopBundle\Component\Cron\CronFacade;
use SS6\ShopBundle\Component\Mutex\MutexFactory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CronCommand extends ContainerAwareCommand {

	protected function configure() {
		$this
			->setName('ss6:cron')
			->setDescription('Maintenance service of ShopSys 6');
	}

	/**
	 * @param \Symfony\Component\Console\Input\InputInterface $input
	 * @param \Symfony\Component\Console\Output\OutputInterface $output
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		$cronFacade = $this->getContainer()->get(CronFacade::class);
		/* @var $cronFacade \SS6\ShopBundle\Component\Cron\CronFacade */
		$mutexFactory = $this->getContainer()->get(MutexFactory::class);
		/* @var $mutexFactory \SS6\ShopBundle\Component\Mutex\MutexFactory */

		$mutex = $mutexFactory->getCronMutex();
		if ($mutex->acquireLock(0)) {
			$cronFacade->runServicesForTime($this->getActualRoundedTime());
			$mutex->releaseLock();
		} else {
			throw new \SS6\ShopBundle\Command\Exception\CronCommandException('Cron can run only one at this time');
		}

	}

	/**
	 * @return \DateTime
	 */
	private function getActualRoundedTime() {
		$time = new \DateTime(null);
		$time->modify('-' . $time->format('s') . ' sec');
		$time->modify('-' . ($time->format('i') % 5) . ' min');

		return $time;
	}

}
