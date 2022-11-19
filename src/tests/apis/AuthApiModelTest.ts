import { ApiTestBase } from '@/tests/apis/ApiTestBase'
import { AuthApiModel } from '@/models/apis/AuthApiModel'


class AuthApiModelTest extends ApiTestBase {
  public static async getAccessTokenByEmailTest(): Promise<string> {
    const authApiModel = new AuthApiModel()

    const result = await authApiModel.getAccessTokenByEmail('test@tools.ponzu0529.com', 'test_password')

    if (result.status !== 'success') {
      console.error('Failure!')
      return ''
    } else {
      console.log(result.data)
      return result.data
    }
  }


  public static async checkAccessTokenByEmailTest(accessToken: string): Promise<void> {
    const authApiModel = new AuthApiModel()

    const result = await authApiModel.checkAccessTokenByEmail('test@tools.ponzu0529.com', accessToken)

    if (result.status !== 'success') {
      console.error('Failure!')
    } else {
      console.log(result.data)
    }
  }


  public static async checkAccessTokenByEmailTest_EmptyEmailAndEmptyAccessToken(): Promise<void> {
    const authApiModel = new AuthApiModel()

    const result = await authApiModel.checkAccessTokenByEmail('', '')

    if (result.status !== 'success') {
      console.error('Failure!')
    } else {
      console.log(result.data)
    }
  }
}


(async () => {
  console.log('GetAccessTokenByEmailTest:')
  const accessToken = await AuthApiModelTest.getAccessTokenByEmailTest()

  console.log('CheckAccessTokenByEmailTest:')
  await AuthApiModelTest.checkAccessTokenByEmailTest(accessToken)

  console.log('===== ===== =====')

  console.log('checkAccessTokenByEmailTest_EmptyEmailAndEmptyAccessToken:')
  await AuthApiModelTest.checkAccessTokenByEmailTest_EmptyEmailAndEmptyAccessToken()
})()
