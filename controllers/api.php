<?php
/**
 *
 */
class Api extends Controller
{
  protected function GetUser()
  {
    $viewModel = new ApiModel;
    $this->ReturnView($viewModel->GetUser(), true);
  }

  protected function GetRide()
  {
    $viewModel = new ApiModel;
    $this->ReturnView($viewModel->GetRide(), true);
  }

  protected function GetRides()
  {
    $viewModel = new ApiModel;
    $this->ReturnView($viewModel->GetRides(), true);
  }

  protected function GetDriver()
  {
    $viewModel = new ApiModel;
    $this->ReturnView($viewModel->GetDriver(), true);
  }
}
