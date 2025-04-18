import React, { useEffect, useState } from "react";
import Label from "../../form/Label";
import Input from "../../form/input/InputField";
import Button from "../button/Button";
import { useModal } from "../../../hooks/useModal";
import { EyeIcon } from "lucide-react";
import { EyeCloseIcon } from "../../../icons";
import { toast } from "react-toastify";
import { useTheme } from "../../../context/ThemeContext";
import axiosInstance from "../../../utils/Interceptor";
import { User } from "../../../utils/types";
import Loader from "../../myComponnets/Loader";
interface closeModalProps {
  closeModal1: () => void;
  action: "add" | "edit";
}

function AddEmployeeModal({ closeModal1, action }: closeModalProps) {
  const [loading, setLoading] = useState(false);
  const [firstName, setFirstName] = useState("");
  const [lastName, setLastName] = useState("");
  const [email, setEmail] = useState("");
  const [username, setUsername] = useState("");
  const [showPassword, setShowPassword] = useState(false);
  const [password, setPassword] = useState("");
  const { toDeleteOrUpdateEmployeeId } = useTheme();
  const { setEmployees } = useTheme();
  const { employees } = useTheme();
  const toEditEmp = employees.find(
    (employee) => employee.id === toDeleteOrUpdateEmployeeId
  );
  const handleSave = async () => {
    try {
      setLoading(true);
      const formData = new FormData();
      formData.append("first_name", firstName);
      formData.append("last_name", lastName);
      formData.append("email", email);
      formData.append("username", username);
      formData.append("password", password);

      if (action === "add") {
        const response = await axiosInstance.post("/employees", formData);
        if (response.status === 201) {
          const newEmployee = (response.data as { user: User }).user;
          setEmployees((prevEmployees) => [...prevEmployees, newEmployee]);
          console.log("newEmployee", newEmployee);
        }
      } else {
        const response = await axiosInstance.put(
          `/employees/${toDeleteOrUpdateEmployeeId}`,
          formData
        );
        if (response.status === 200) {
          const updatedEmployee = (response.data as { user: User }).user;
          setEmployees((prevEmployees) =>
            prevEmployees.map((employee) =>
              employee.id === updatedEmployee.id ? updatedEmployee : employee
            )
          );
        }
      }

      closeModal1();
    } catch (error: any) {
      setLoading(false);
      closeModal1();
      toast.error(error.response?.data?.message || "Failed to add employee.");
    }
  };

  useEffect(() => {
    if (action === "edit" && toEditEmp) {
      setFirstName(toEditEmp.first_name);
      setLastName(toEditEmp.last_name);
      setEmail(toEditEmp.email);
      setUsername(toEditEmp.username);
    }
  }, [action, toEditEmp]);

  return (
    <div className="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11 ">
      <div className="px-2 pr-14">
        <h4 className="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
          {action === "add" ? "Add New Employee" : "Edit Employee"}
        </h4>
        <p className="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
          all inputs are required
        </p>
      </div>
      <div className="flex flex-col">
        <div className="custom-scrollbar h-[350px] overflow-y-auto px-2 pb-3">
          <div className="mt-7">
            <div className="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
              <div className="col-span-2 lg:col-span-1">
                <Label>First Name</Label>
                <Input
                  type="text"
                  value={firstName}
                  onChange={(e) => setFirstName(e.target.value)}
                />
              </div>

              <div className="col-span-2 lg:col-span-1">
                <Label>Last Name</Label>
                <Input
                  type="text"
                  value={lastName}
                  onChange={(e) => setLastName(e.target.value)}
                />
              </div>

              <div className="col-span-2 lg:col-span-1">
                <Label>Email Address</Label>
                <Input
                  type="text"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                />
              </div>

              <div className="col-span-2 lg:col-span-1">
                <Label>User Name</Label>
                <Input
                  type="text"
                  value={username}
                  onChange={(e) => setUsername(e.target.value)}
                />
              </div>

              <div className="col-span-2">
                <Label>Password</Label>
                <div className="relative">
                  <Input
                    type={showPassword ? "text" : "password"}
                    placeholder="Enter your password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                  />
                  <span
                    onClick={() => setShowPassword(!showPassword)}
                    className="absolute z-30 -translate-y-1/2 cursor-pointer right-4 top-1/2"
                  >
                    {showPassword ? (
                      <EyeIcon className="fill-gray-500 dark:fill-gray-400 size-5" />
                    ) : (
                      <EyeCloseIcon className="fill-gray-500 dark:fill-gray-400 size-5" />
                    )}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div className="flex items-center gap-3 px-2 mt-6 justify-end">
          <Button
            size="sm"
            variant="outline"
            onClick={closeModal1}
            disabled={loading}
          >
            Close
          </Button>
          <Button size="sm" onClick={handleSave} disabled={loading}>
            {loading ? <Loader /> : action === "add" ? "Add" : "Update"}
          </Button>
        </div>
      </div>
    </div>
  );
}

export default AddEmployeeModal;
