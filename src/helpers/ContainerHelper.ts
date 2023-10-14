import { container } from '@/container';

/**
 * Container Helper
 */
export class ContainerHelper {
    /**
     * Bind
     * @param serviceIdentifier The interface or class symbol
     * @param constructor The class constructor
     */
    public static bind<T>(serviceIdentifier: string, constructor: {
        new (...args: any[]): T;
    }): void {
        container.bind<T>(serviceIdentifier).to(constructor);
    }

    /**
     * Rebind
     * @param serviceIdentifier The interface or class symbol
     * @param constructor The class constructor
     */
    public static rebind<T>(serviceIdentifier: string, constructor: {
        new (...args: any[]): T;
    }): void {
        container.rebind<T>(serviceIdentifier).to(constructor);
    }

    /**
     * Get
     * @param serviceIdentifier The interface or class symbol
     * @returns The class instance
     */
    public static get<T>(serviceIdentifier: string): T {
        return container.get<T>(serviceIdentifier);
    }
}