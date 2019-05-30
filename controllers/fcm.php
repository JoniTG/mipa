<?php
/**
 *
 */
class Fcm extends Controller
{
  public function register()
  {
    $viewModel = new FcmModel;
    $this->ReturnView($viewModel->register(), true);
  }

  // public function Notification()
  // {
  //   $viewModel = new FcmModel;
  //   $this->ReturnView($viewModel->Notification(), true);
  // }
}
