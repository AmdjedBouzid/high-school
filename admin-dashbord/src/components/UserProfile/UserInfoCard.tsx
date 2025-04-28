import { useTheme } from "../../context/ThemeContext";
import axiosInstance from "../../utils/Interceptor";
import { toast } from "react-toastify";
import { useState } from "react";
import Loader from "../myComponnets/Loader";
import { Supervisor, User } from "../../utils/types";

interface UserInfoCardProps {
  user: User | Supervisor | null | undefined;
}

export default function UserInfoCard({ user }: UserInfoCardProps) {
  const { setUser } = useTheme();
  const [logOutLoader, setLogOutLoader] = useState<boolean>(false);

  const handleLogout = async () => {
    try {
      setLogOutLoader(true);
      await axiosInstance.post("/logout");
      setUser(null);
      localStorage.removeItem("token");
      toast.success("Logout successful");
    } catch (error) {
      toast.error("Logout failed. Please try again.");
    }
  };

  const isSupervisor = user?.role === "Supervisor" && "supervisor_info" in user;

  return (
    <div className="p-5 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
      <div className="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
        <div>
          <h4 className="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">
            Personal Information
          </h4>

          <div className="grid grid-cols-2 gap-4 lg:grid-cols-3 lg:gap-7 2xl:gap-x-32">
            <div>
              <p className="mb-2 text-xs text-gray-500 dark:text-gray-400">
                First Name
              </p>
              <p className="text-sm font-medium text-gray-800 dark:text-white/90">
                {user?.first_name}
              </p>
            </div>

            <div>
              <p className="mb-2 text-xs text-gray-500 dark:text-gray-400">
                Last Name
              </p>
              <p className="text-sm font-medium text-gray-800 dark:text-white/90">
                {user?.last_name}
              </p>
            </div>

            <div>
              <p className="mb-2 text-xs text-gray-500 dark:text-gray-400">
                Email Address
              </p>
              <p className="text-sm font-medium text-gray-800 dark:text-white/90">
                {user?.email}
              </p>
            </div>

            <div>
              <p className="mb-2 text-xs text-gray-500 dark:text-gray-400">
                Username
              </p>
              <p className="text-sm font-medium text-gray-800 dark:text-white/90">
                {user?.username}
              </p>
            </div>

            <div>
              <p className="mb-2 text-xs text-gray-500 dark:text-gray-400">
                Role
              </p>
              <p className="text-sm font-medium text-gray-800 dark:text-white/90">
                {user?.role}
              </p>
            </div>

            {/* Supervisor Specific Info */}
            {isSupervisor && (
              <>
                <div>
                  <p className="mb-2 text-xs text-gray-500 dark:text-gray-400">
                    Phone Number
                  </p>
                  <p className="text-sm font-medium text-gray-800 dark:text-white/90">
                    {user.supervisor_info.phone_number}
                  </p>
                </div>

                <div>
                  <p className="mb-2 text-xs text-gray-500 dark:text-gray-400">
                    Address
                  </p>
                  <p className="text-sm font-medium text-gray-800 dark:text-white/90">
                    {user.supervisor_info.address}
                  </p>
                </div>

                <div>
                  <p className="mb-2 text-xs text-gray-500 dark:text-gray-400">
                    Sexe
                  </p>
                  <p className="text-sm font-medium text-gray-800 dark:text-white/90">
                    {user.supervisor_info.sexe}
                  </p>
                </div>
              </>
            )}
          </div>
        </div>

        {/* Logout button (for non-Supervisors) */}
        {user?.role !== "Supervisor" && (
          <button
            disabled={logOutLoader}
            onClick={handleLogout}
            className="flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 lg:inline-flex lg:w-auto"
          >
            <svg
              className="fill-current"
              width="18"
              height="18"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fillRule="evenodd"
                clipRule="evenodd"
                d="M16 13V11H8V8L3 12L8 16V13H16ZM20 3H12C10.9 3 10 3.9 10 5V9H12V5H20V19H12V15H10V19C10 20.1 10.9 21 12 21H20C21.1 21 22 20.1 22 19V5C22 3.9 21.1 3 20 3Z"
              />
            </svg>
            {logOutLoader ? <Loader /> : "Logout"}
          </button>
        )}
      </div>
    </div>
  );
}
