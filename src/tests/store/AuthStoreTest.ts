import { StoreTestBase } from '@/tests/store/StoreTestBase';
import { authModule } from '@/store/modules/AuthStore';


export class AuthStoreTest extends StoreTestBase {
  public static async login_Success(): Promise<void> {
    authModule.setEmail('test@tools.ponzu0529.com');
    authModule.setPassword('test_password');
    await authModule.login();
    this.outputAuthModule();
  }

  public static async login_DummyEmail(): Promise<void> {
    authModule.setEmail('dummy@tools.ponzu0529.com');
    authModule.setPassword('test_password');
    await authModule.login();
    this.outputAuthModule();
  }

  public static async login_DummyPassword(): Promise<void> {
    authModule.setEmail('test@tools.ponzu0529.com');
    authModule.setPassword('dummy_password');
    await authModule.login();
    this.outputAuthModule();
  }

  public static async checkAccessToken_Success(): Promise<void> {
    authModule.setEmail('test@tools.ponzu0529.com');
    authModule.setPassword('test_password');
    await authModule.login();
    await authModule.checkAccessToken();
    this.outputAuthModule();
  }

  public static async checkAccessToken_OldAccessToken(): Promise<void> {
    authModule.setEmail('test@tools.ponzu0529.com');
    authModule.setPassword('test_password');
    authModule.setLastAccessToken('old_access_token');
    await authModule.checkAccessToken();
    this.outputAuthModule();
  }

  private static outputAuthModule(): void {
    console.log(`  name: ${authModule.auth.name}`);
    console.log(`  email: ${authModule.auth.email}`);
    console.log(`  password: ${authModule.auth.password}`);
    console.log(`  lastAccessToken: ${authModule.auth.lastAccessToken}`);
    console.log(`  isLogin: ${authModule.isLogin}`);
  }
}


(async () => {
  console.log('Login_Success:');
  await AuthStoreTest.login_Success();

  console.log('===== ===== =====');

  console.log('Login_DummyEmail:');
  await AuthStoreTest.login_DummyEmail();

  console.log('===== ===== =====');

  console.log('Login_DummyPassword:');
  await AuthStoreTest.login_DummyPassword();

  console.log('===== ===== =====');

  console.log('CheckAccessToken_Success:');
  await AuthStoreTest.checkAccessToken_Success();

  console.log('===== ===== =====');

  console.log('CheckAccessToken_OldAccessToken:');
  await AuthStoreTest.checkAccessToken_OldAccessToken();
})();
