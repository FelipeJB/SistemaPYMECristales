from selenium import webdriver
from aux_medidas_home_page import AuxMedidasHomePage
import pytest

@pytest.fixture(scope="module")
def poAuxMedidasHomePage():
    #Setup
    driver = webdriver.Firefox()
    poAuxMedidasHomePage = AuxMedidasHomePage(driver)
    yield poAuxMedidasHomePage
    #Teardown
    driver.quit()

#Test case ID: TC-8
class TestAuxMedidasPageContent(object):

    def test_tomar_medidas(self, poAuxMedidasHomePage):        
        assert poAuxMedidasHomePage.tomar_medidas_exists() == True

    def test_generar_planos(self, poAuxMedidasHomePage):
        assert poAuxMedidasHomePage.generar_planos_exists() == True

    def test_ver_ventas(self, poAuxMedidasHomePage):
        assert poAuxMedidasHomePage.ver_ventas_exists() == True

    def test_generar_informe_venta(self, poAuxMedidasHomePage):
        assert poAuxMedidasHomePage.generar_informe_venta_exists() == True