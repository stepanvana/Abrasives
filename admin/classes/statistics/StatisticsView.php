<?php

namespace admin\statistics;

class StatisticsView extends Statistics {

	public function showDataByDate($from=NULL, $to=NULL) {
		if (is_numeric($from)) {
			$from = date("Y-m-d", strtotime("-".$from." days", strtotime($to)));
		}
		$result = $this->getDataByDate($from, $to);
		return $result;
	}

	public function showDataOrders($from=NULL, $to=NULL) {
		if (is_numeric($from)) {
			$from = date("Y-m-d", strtotime("-".$from." days", strtotime($to)));
		}
		$result = $this->getDataOrders($from, $to);
		return $result;
	}

	public function showDateProducts($from=NULL, $to=NULL) {
		if (is_numeric($from)) {
			$from = date("Y-m-d", strtotime("-".$from." days", strtotime($to)));
		}
		$result = $this->getDateProducts($from, $to);
		return $result;
	}

	public function showIdProducts($from=NULL, $to=NULL) {
		if (is_numeric($from)) {
			$from = date("Y-m-d", strtotime("-".$from." days", strtotime($to)));
		}
		$result = $this->getIdProducts($from, $to);
		return $result;
	}

	public function compareTwoWeeks() {
		//DATA TOHOTO TÝDNE
		$thisWeekArray = $this->showDataByDate(7, date('Y-m-d', strtotime(' +1 day')));
		$thisWeekIncome = array_sum(array_column($thisWeekArray, 'income'));
		$thisWeekEarnings = array_sum(array_column($thisWeekArray, 'earnings'));
		$thisWeekOrders = array_sum(array_column($thisWeekArray, 'numberOrders'));
		//DATA MINULÉHO TÝDNE
		$lastWeekArray = $this->showDataByDate(14, date('Y-m-d', strtotime(' -6 day')));
		$lastWeekIncome = array_sum(array_column($lastWeekArray, 'income'));
		$lastWeekEarnings = array_sum(array_column($lastWeekArray, 'earnings'));
		$lastWeekOrders = array_sum(array_column($lastWeekArray, 'numberOrders'));

		if ($thisWeekIncome !== 0 && $lastWeekIncome !== 0) {
			if ($thisWeekIncome > $lastWeekIncome) {
				$compareIncomes = (($thisWeekIncome / $lastWeekIncome)-1) * 100;
			} elseif ($thisWeekIncome < $lastWeekIncome) {
				$compareIncomes = (($lastWeekIncome / $thisWeekIncome)-1) * (-100);
			} else {
				$compareIncomes = 0;
			}	
		} elseif ($thisWeekIncome == 0 || $lastWeekIncome == 0) {
			if ($thisWeekIncome == 0) {
				$thisWeekIncome = 0;
				$compareIncomes = ($lastWeekIncome - $thisWeekIncome)*(-1);
			} elseif ($lastWeekIncome == 0) {
				$lastWeekIncome = 0;
				$compareIncomes = $thisWeekIncome - $lastWeekIncome;
			}
		}

		if ($thisWeekEarnings !== 0 && $lastWeekEarnings !== 0) {
			if ($thisWeekEarnings > $lastWeekEarnings) {
				if ($lastWeekEarnings < 0) {
					$compareEarnings = (($thisWeekEarnings / $lastWeekEarnings)-1) * (-100);
				} else {
					$compareEarnings = (($thisWeekEarnings / $lastWeekEarnings)-1) * 100;
				}
			} elseif ($thisWeekEarnings < $lastWeekEarnings) {
				if ($thisWeekEarnings<0) {
					$compareEarnings = (($lastWeekEarnings / $thisWeekEarnings)-1) * 100;
				} else {
					$compareEarnings = (($lastWeekEarnings / $thisWeekEarnings)-1) * (-100);
				}
			} else {
				$compareEarnings = 0;
			}	
		} elseif ($thisWeekEarnings == 0 || $lastWeekEarnings == 0) {
			if ($thisWeekEarnings == 0) {
				$thisWeekEarnings = 0;
				$compareEarnings = ($lastWeekEarnings - $thisWeekEarnings)*(-1);
			} elseif ($lastWeekEarnings == 0) {
				$lastWeekEarnings = 0;
				$compareEarnings = $thisWeekEarnings - $lastWeekEarnings;
			}
		} else {
			$compareEarnings = 0;
		}

		if ($thisWeekIncome == 0 && $thisWeekOrders == 0) {
			$thisWeekAvarage = 0;
		} else {
			$thisWeekAvarage = $thisWeekIncome/$thisWeekOrders;
		}
		if ($lastWeekIncome == 0 && $lastWeekOrders == 0) {
			$lastWeekAvarage = 0;
		} else {
			$lastWeekAvarage = $lastWeekIncome/$lastWeekOrders;
		}
		if ($thisWeekAvarage > 0 && $lastWeekAvarage > 0) {
			if ($thisWeekAvarage > $lastWeekAvarage) {
				$compareAvarage = (($thisWeekAvarage / $lastWeekAvarage)-1) * 100;
			} elseif ($thisWeekAvarage < $lastWeekAvarage) {
				$compareAvarage = (($lastWeekAvarage / $thisWeekAvarage)-1) * (-100);
			} else {
				$compareAvarage = 0;
			}	
		} elseif ($thisWeekAvarage == 0 || $lastWeekAvarage == 0) {
			if ($thisWeekAvarage == 0) {
				$thisWeekAvarage = 0;
				$compareAvarage = ($lastWeekAvarage - $thisWeekAvarage)*(-1);
			} elseif ($lastWeekAvarage == 0) {
				$lastWeekAvarage = 0;
				$compareAvarage = $thisWeekAvarage - $lastWeekAvarage;
			}
		}
		
		if ($thisWeekOrders > 0 && $lastWeekOrders > 0) {
			if ($thisWeekOrders > $lastWeekOrders) {
				$compareOrders = (($thisWeekOrders / $lastWeekOrders)-1) * 100;
			} elseif ($thisWeekOrders < $lastWeekOrders) {
				$compareOrders = (1-($thisWeekOrders / $lastWeekOrders)) * (-100);
			} else {
				$compareOrders = 0;
			}	
		} else {
			$compareOrders = ($thisWeekOrders*100) - ($lastWeekOrders*100);
		}
		$result = array('compareIncomes'=>$compareIncomes, 'compareEarnings'=>$compareEarnings, 'compareAvarage'=>$compareAvarage, 'compareOrders'=>$compareOrders);
		return $result;
	}

	public function showLatestOrders() {
		$result = $this->getLatestOrders();
		return $result;
	}

}