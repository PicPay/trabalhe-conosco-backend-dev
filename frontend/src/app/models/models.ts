export interface Page {
    content: Array<User>;
    totalPages: number;
    totalElements: number;
    last: boolean;
    size: number;
    number: number;
    sort?: any;
    numberOfElements: number;
    first: boolean;
};

export interface User {
    id: string;
    name: string;
    userName: string;
    relevancy: number;
};

