from selenium.webdriver.common.by import By
from base_page import Page

class LoginPage(Page):

    def __init__(self, driver):
        super(LoginPage,self).__init__(driver)
        self.url = "login"
        self.open(self.url) 

        self.username_field = "#identity"
        self.password_field = "#password"
        self.login_button = ".btn"

    def loginWithCredentials(self, user, password):
        username_elem = self.driver.find_element(By.CSS_SELECTOR, self.username_field)
        password_elem = self.driver.find_element(By.CSS_SELECTOR, self.password_field)
        button_elem = self.driver.find_element(By.CSS_SELECTOR, self.login_button)

        username_elem.send_keys(user)
        password_elem.send_keys(password)
        button_elem.click()
