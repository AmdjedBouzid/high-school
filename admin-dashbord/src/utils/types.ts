export type User = {
  id: number;
  name: string;
  email: string;
};
export type ThemeContextType = {
  theme: Theme;
  toggleTheme: () => void;
  user: User | null;
  setUser: React.Dispatch<React.SetStateAction<User | null>>;
};

export type Theme = "light" | "dark";
export type NavItem = {
  name: string;
  icon: React.ReactNode;
  path?: string;
  subItems?: { name: string; path: string; pro?: boolean; new?: boolean }[];
};
