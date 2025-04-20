import { useEffect, useState } from "react";
import Label from "../../form/Label";
import Input from "../../form/input/InputField";
import Button from "../button/Button";
// import { useModal } from "../../../hooks/useModal";
import { EyeIcon, ChevronDown } from "lucide-react";
import { EyeCloseIcon } from "../../../icons";
import { toast } from "react-toastify";
import { useTheme } from "../../../context/ThemeContext";
import axiosInstance from "../../../utils/Interceptor";
import {
  //   Supervisor,
  //   supervisorArrayResponse,
  supervisorResponse,
} from "../../../utils/types";
import Loader from "../../myComponnets/Loader";
interface closeModalProps {
  closeModal1: () => void;
  action: "add" | "edit";
}

function AddSupervisorModal({ closeModal1, action }: closeModalProps) {
  const { supervisors, setSupervisors } = useTheme();
  const [loading, setLoading] = useState(false);
  const [firstName, setFirstName] = useState("");
  const [lastName, setLastName] = useState("");
  const [email, setEmail] = useState("");
  const [username, setUsername] = useState("");
  const [showPassword, setShowPassword] = useState(false);
  const [showPasswordConfirmation, setShowPasswordConfirmation] =
    useState(false);
  const [phoneNumber, setPhoneNumber] = useState("");
  const [adress, setAdress] = useState("");
  const [password, setPassword] = useState("");

  const [sex, setSex] = useState("M");
  const [passwordConfirmation, setPasswordConfirmation] = useState("");
  const { toDeleteOrUpdateEmployeeId } = useTheme();

  const toEditEmp = supervisors.find(
    (supervisors) => supervisors.id === toDeleteOrUpdateEmployeeId
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
      formData.append("phone_number", phoneNumber);
      formData.append("password_confirmation", passwordConfirmation);
      formData.append("sexe", sex);
      formData.append("address", adress);

      if (action === "add") {
        const response = await axiosInstance.post("/supervisor", formData);
        if (response.status === 201) {
          const responseData = response.data as supervisorResponse;
          const newSupervisor = responseData.data;
          setSupervisors((prev) => [...prev, newSupervisor]);
        }
      } else {
        // const response = await axiosInstance.put(
        //   `/employees/${toDeleteOrUpdateEmployeeId}`,
        //   formData
        // );
        // if (response.status === 200) {
        //   const updatedEmployee = (response.data as { user: User }).user;
        //   setEmployees((prevEmployees) =>
        //     prevEmployees.map((employee) =>
        //       employee.id === updatedEmployee.id ? updatedEmployee : employee
        //     )
        //   );
        // }
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
      setPhoneNumber(toEditEmp.supervisor_info.phone_number);
      setAdress(toEditEmp.supervisor_info.address);
    }
  }, [action, toEditEmp]);

  return (
    <div className="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11 ">
      <div className="px-2 pr-14">
        <h4 className="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
          {action === "add" ? "Add New Supervisor" : "Edit Supervisor"}
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
              <div className="col-span-2 lg:col-span-1">
                <Label>phone Number</Label>
                <Input
                  type="text"
                  value={phoneNumber}
                  onChange={(e) => setPhoneNumber(e.target.value)}
                />
              </div>
              <div className="col-span-2 lg:col-span-1 relative">
                <Label>Sex</Label>
                <select
                  className="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 cursor-pointer"
                  defaultValue="M"
                  value={sex}
                  onChange={(e) => setSex(e.target.value)}
                >
                  <option value="M">Male</option>
                  <option value="F">Female</option>
                </select>
                <span className="pointer-events-none absolute right-3 top-10  text-gray-500 dark:text-white/60">
                  <ChevronDown className="w-4 h-4" />
                </span>
              </div>
              <div className="col-span-2 lg:col-span-1">
                <Label>Adress</Label>
                <Input
                  type="text"
                  value={adress}
                  onChange={(e) => setAdress(e.target.value)}
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
              <div className="col-span-2">
                <Label>Password confirmation</Label>
                <div className="relative">
                  <Input
                    type={showPasswordConfirmation ? "text" : "password"}
                    placeholder="Enter your password"
                    value={passwordConfirmation}
                    onChange={(e) => setPasswordConfirmation(e.target.value)}
                  />
                  <span
                    onClick={() =>
                      setShowPasswordConfirmation(!showPasswordConfirmation)
                    }
                    className="absolute z-30 -translate-y-1/2 cursor-pointer right-4 top-1/2"
                  >
                    {showPasswordConfirmation ? (
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

export default AddSupervisorModal;
