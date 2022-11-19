import { ModelTestBase } from '@/tests/models/ModelTestBase'
import { AuthModel } from '@/models/AuthModel'


class AuthModelTest extends ModelTestBase {
  public static async loginTest_Success(): Promise<void> {
    const authModel = new AuthModel()
    authModel.email = 'test@tools.ponzu0529.com'
    authModel.password = 'test_password'

    const result = await authModel.login()

    console.log(result)
  }


  public static async loginTest_DummyEmail(): Promise<void> {
    const authModel = new AuthModel()
    authModel.email = 'dummy@tools.ponzu0529.com'
    authModel.password = 'test_password'

    const result = await authModel.login()

    console.log(result)
  }


  public static async loginTest_DummyPassword(): Promise<void> {
    const authModel = new AuthModel()
    authModel.email = 'test@tools.ponzu0529.com'
    authModel.password = 'dummy_password'

    const result = await authModel.login()

    console.log(result)
  }


  public static async checkAccessTokenTest_Success(): Promise<void> {
    const authModel = new AuthModel()
    authModel.email = 'test@tools.ponzu0529.com'
    authModel.password = 'test_password'

    await authModel.login()
    const result = await authModel.checkAccessToken()

    console.log(result)
  }


  public static async checkAccessTokenTest_OldAccessToken(): Promise<void> {
    const authModel = new AuthModel()

    authModel.email = 'access_token_test@tools.ponzu0529.com'
    authModel.lastAccessToken = 'old_access_token'
    const result = await authModel.checkAccessToken()

    console.log(result)
  }
}


(async () => {
  console.log('LoginTest_Success:')
  await AuthModelTest.loginTest_Success()

  console.log('===== ===== =====')

  console.log('LoginTest_DummyEmail:')
  await AuthModelTest.loginTest_DummyEmail()

  console.log('===== ===== =====')

  console.log('LoginTest_DummyPassword:')
  await AuthModelTest.loginTest_DummyPassword()

  console.log('===== ===== =====')

  console.log('CheckAccessTokenTest_Success:')
  await AuthModelTest.checkAccessTokenTest_Success()

  console.log('===== ===== =====')

  console.log('CheckAccessTokenTest_OldAccessToken:')
  await AuthModelTest.checkAccessTokenTest_OldAccessToken()
})()
