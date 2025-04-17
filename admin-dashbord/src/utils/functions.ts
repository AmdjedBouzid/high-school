import { User } from "../utils/types";
import axiosInstance from "./Interceptor";
export const getToken = (): string | null => {
  return localStorage.getItem("token");
};

export const getCurrentUser = async (): Promise<User | null> => {
  try {
    const response = await axiosInstance.get("/profile");
    return response.data as User;
  } catch (error) {
    return null;
  }
};

export function formatCustomDate(isoString: string): string {
  const date = new Date(isoString);

  const hours = date.getHours().toString().padStart(2, "0");
  const minutes = date.getMinutes().toString().padStart(2, "0");
  const day = date.getDate().toString().padStart(2, "0");
  const month = (date.getMonth() + 1).toString().padStart(2, "0");
  const year = date.getFullYear();

  return `${hours}:${minutes} ${day}/${month}/${year}`;
}
