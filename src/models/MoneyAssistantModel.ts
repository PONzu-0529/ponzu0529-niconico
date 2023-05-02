import Utils from '@/common/Utils';
import ApiHelper from '@/common/ApiHelper';

export default class MoneyAssistantModel {
  public static async getAllPayment(): Promise<Array<PaymentResponse>> {
    return await ApiHelper.get(`${Utils.getHostWithProtocol()}/api/money-assistant/payment`);
  }

  public static async getPaymentById(id: number): Promise<PaymentResponse> {
    return await ApiHelper.get(`${Utils.getHostWithProtocol()}/api/money-assistant/payment/${id}`);
  }

  public static async addPayment(payment: PaymentRequest): Promise<number> {
    return await ApiHelper.post(`${Utils.getHostWithProtocol()}/api/money-assistant/payment`, payment);
  }

  public static async updatePayment(id: number, payment: PaymentRequest): Promise<void> {
    return await ApiHelper.put(`${Utils.getHostWithProtocol()}/api/money-assistant/payment/${id}`, payment);
  }

  public static async deletePayment(id: number): Promise<void> {
    return await ApiHelper.delete(`${Utils.getHostWithProtocol()}/api/money-assistant/payment/${id}`);
  }

  public static async getAllExpense(): Promise<Array<ExpenseResponse>> {
    return await ApiHelper.get(`${Utils.getHostWithProtocol()}/api/money-assistant/expense`);
  }

  public static async getExpenseById(id: number): Promise<ExpenseResponse> {
    return await ApiHelper.get(`${Utils.getHostWithProtocol()}/api/money-assistant/expense/${id}`);
  }

  public static async addExpense(expense: ExpenseRequest): Promise<number> {
    return await ApiHelper.post(`${Utils.getHostWithProtocol()}/api/money-assistant/expense`, expense);
  }

  public static async updateExpense(id: number, expense: ExpenseRequest): Promise<void> {
    return await ApiHelper.put(`${Utils.getHostWithProtocol()}/api/money-assistant/expense/${id}`, expense);
  }

  public static async deleteExpense(id: number): Promise<void> {
    return await ApiHelper.delete(`${Utils.getHostWithProtocol()}/api/money-assistant/expense/${id}`);
  }
}

type PaymentRequest = PaymentBase

interface PaymentResponse extends PaymentBase {
  id: number
}

interface PaymentBase {
  title: string
}

interface ExpenseRequest extends ExpenseBase {
  items: Array<ExpenseItemRequest>
}

interface ExpenseResponse extends ExpenseBase {
  items: Array<ExpenseItemResponse>
}

interface ExpenseBase {
  title: string,
  date: string
  to: string,
  memo: string
}

type ExpenseItemRequest = ExpenseItemBase

interface ExpenseItemResponse extends ExpenseItemBase {
  payment: PaymentResponse
}

interface ExpenseItemBase {
  title: string,
  money: number,
  payment_id: number
}
