import { ModelTestBase } from '@/tests/models/ModelTestBase'
import { AuthModel } from '@/models/AuthModel'


class AuthModelTest extends ModelTestBase {
  public static async loginTest_Success(): Promise<void> {
    const authModel = new AuthModel()

    const result = await authModel.login('test@tools.ponzu0529.com', 'test_password')

    console.log(result)
  }


  public static async loginTest_DummyEmail(): Promise<void> {
    const authModel = new AuthModel()

    const result = await authModel.login('dummy@tools.ponzu0529.com', 'test_password')

    console.log(result)
  }


  public static async loginTest_DummyPassword(): Promise<void> {
    const authModel = new AuthModel()

    const result = await authModel.login('test@tools.ponzu0529.com', 'dummy_password')

    console.log(result)
  }


  public static async checkAccessTokenTest_Success(): Promise<void> {
    const authModel = new AuthModel()

    await authModel.login('test@tools.ponzu0529.com', 'test_password')
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
