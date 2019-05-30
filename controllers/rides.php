<?php
/**
 *
 */
class Rides extends Controller
{
  protected function GiveRide()
  {
    $viewModel = new RideModel;
    $this->ReturnView($viewModel->GiveRide(), true);
  }

  protected function ChooseRide()
  {
    $viewModel = new RideModel;
    $this->ReturnView($viewModel->ChooseRide(), true);
  }

  protected function ChooseDriver()
  {
    $viewModel = new RideModel;
    $this->ReturnView($viewModel->ChooseDriver(), true);
  }

  protected function MyRides()
  {
    $viewModel = new RideModel;
    $this->ReturnView($viewModel->MyRides(), true);
  }
}
