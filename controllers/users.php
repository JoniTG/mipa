<?php
/**
 *
 */
class User extends Controller
{
  protected function register()
  {
    $viewModel = new UserModel;
    $this->ReturnView($viewModel->register(), true);
  }

  protected function sum()
  {
    $viewModel = new UserModel;
    $this->ReturnView($viewModel->sum(), true);
  }

  protected function profile()
  {
    $viewModel = new UserModel;
    $this->ReturnView($viewModel->profile(), true);
  }

  protected function login()
  {
    $viewModel = new UserModel;
    $this->ReturnView($viewModel->login(), true);
  }

  protected function logpros()
  {
    $viewModel = new UserModel;
    $this->ReturnView($viewModel->logpros(), true);
  }

  protected function regt()
  {
    $viewModel = new UserModel;
    $this->ReturnView($viewModel->regt(), true);
  }

  protected function UpdatePic()
  {
    $viewModel = new UserModel;
    $this->ReturnView($viewModel->UpdatePic(), true);
  }

  protected function continueToMain()
  {
    $viewModel = new UserModel;
    $this->ReturnView($viewModel->continueToMain(), true);
  }

  protected function Index()
  {
    $viewModel = new UserModel;
    $this->ReturnView($viewModel->Index(), true);
  }

  protected function settings()
  {
    $viewModel = new UserModel;
    $this->ReturnView($viewModel->settings(), true);
  }

  protected function payment()
  {
    $viewModel = new UserModel;
    $this->ReturnView($viewModel->payment(), true);
  }

  protected function cancel()
  {
    $viewModel = new UserModel;
    $this->ReturnView($viewModel->cancel(), true);
  }
}
