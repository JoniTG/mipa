<?php
/**
 *
 */
class Admin extends Controller
{
  protected function Index()
  {
    $viewModel = new AdminModel;
    $this->ReturnView($viewModel->Index(), true);
  }

  protected function login()
  {
    $viewModel = new AdminModel;
    $this->ReturnView($viewModel->login(), true);
  }

  protected function logout()
  {
    $viewModel = new AdminModel;
    $this->ReturnView($viewModel->logout(), true);
  }

  /* ##################################
   *          Rides methods
   * ##################################
  */
  protected function rides()
  {
    $viewModel = new AdminModel;
    $this->ReturnView($viewModel->rides(), true);
  }

  protected function Edit()
  {
    $viewModel = new AdminModel;
    $this->ReturnView($viewModel->Edit(), true);
  }

  protected function Delete()
  {
    $viewModel = new AdminModel;
    $this->ReturnView($viewModel->Delete(), true);
  }

  protected function drivers()
  {
    $viewModel = new AdminModel;
    $this->ReturnView($viewModel->drivers(), true);
  }

  protected function DelUser()
  {
    $viewModel = new AdminModel;
    $this->ReturnView($viewModel->DelUser(), true);
  }

  protected function promotion()
  {
    $viewModel = new AdminModel;
    $this->ReturnView($viewModel->promotion(), true);
  }

  protected function demotion()
  {
    $viewModel = new AdminModel;
    $this->ReturnView($viewModel->demotion(), true);
  }

  protected function EditRate()
  {
    $viewModel = new AdminModel;
    $this->ReturnView($viewModel->EditRate(), true);
  }

  protected function message()
  {
    $viewModel = new AdminModel;
    $this->ReturnView($viewModel->message(), true);
  }
}
