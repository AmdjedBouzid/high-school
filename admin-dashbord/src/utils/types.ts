export type User = {
  id: number;
  first_name: string;
  last_name: string;
  username: string;
  email: string;
  role: string; // e.g. "super-admin"
  created_at: string; // ISO date string
  updated_at: string; // ISO date string
};
export type ThemeContextType = {
  theme: Theme;
  toggleTheme: () => void;
  user: User | null;
  setUser: React.Dispatch<React.SetStateAction<User | null>>;
  employees: User[];
  setEmployees: React.Dispatch<React.SetStateAction<User[]>>;
  toDeleteOrUpdateEmployeeId: number;
  setToDeleteOrUpdateEmployeeId: React.Dispatch<React.SetStateAction<number>>;
};

export type Theme = "light" | "dark";
export type NavItem = {
  name: string;
  icon: React.ReactNode;
  path?: string;
  subItems?: { name: string; path: string; pro?: boolean; new?: boolean }[];
};

export type LoginResponse = {
  token: string;
  user: {
    id: number;
    first_name: string;
    last_name: string;
    username: string;
    email: string;
    role: string; // e.g. "super-admin"
    created_at: string; // ISO date string
    updated_at: string; // ISO date string
  };
};
